<?php

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>, Darko Selesi <hallo@w3scouts.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace W3S\LiCRM;

/**
 * Class InvoiceGeneration
 */
class InvoiceGeneration extends \Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->import('Database');
    }

	public function generateAlias($varValue, \DataContainer $dc)
	{
		$autoAlias = false;

		// Generate alias if there is none
		if (!strlen($varValue))
		{
			$autoAlias = true;
			$varValue = standardize($dc->activeRecord->title);
		}

		$objAlias = $this->Database->prepare("
		    SELECT id
		    FROM tl_li_invoice_generation
		    WHERE alias = ?
		")->execute($varValue);

		// Check whether the new alias exists
		if ($objAlias->numRows > 1 && !$autoAlias)
		{
			throw new \Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
		}

		// Add ID to alias
		if ($objAlias->numRows && $autoAlias)
		{
			$varValue .= '-'.$dc->id;
		}
		return $varValue;
	}
	
	public function generateAliasWithoutDC($title, $id)
    {
        // Generate alias
        $alias = standardize($title);

        $objAlias = $this->Database->prepare("
            SELECT id
            FROM tl_li_invoice_generation
            WHERE alias = ?
        ")->executeUncached($alias);

        // Check whether the news alias exists
        if ($objAlias->numRows > 1)
        {
            throw new \Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $alias));
        }

        // Add ID to alias
        if ($objAlias->numRows)
        {
            $alias .= '-'.$id;
        }
        return $alias;
    }

    public function generateInvoices()
    {
        $this->loadLanguageFile('tl_li_invoice');

        $objInvoiceGenerations = $this->Database->prepare("
            SELECT id, toCustomer, toCategory, currency, maturity, generationInverval, generatedLast,
                headline, toTemplate, toAddress, descriptionBefore, fixedPositions, servicePositions,
                productPositions, hourPositions, discount, earlyPaymentDiscount, descriptionAfter,
                publishImmediately, sendImmediately
            FROM
              tl_li_invoice_generation
            WHERE
              DATE(FROM_UNIXTIME(startDate)) <= CURRENT_DATE
            ORDER
              BY id ASC
        ")->execute();

        while($objInvoiceGenerations->next() != null)
        {
            $generatedLast = $objInvoiceGenerations->generatedLast;
            $interval = $objInvoiceGenerations->generationInverval;
            switch($interval)
            {
                case 'weekly':      $unit = 'week'; $value = 1; break;
                case 'biweekly':    $unit = 'week'; $value = 2; break;
                case 'monthly':     $unit = 'month'; $value = 1; break;
                case 'bimonthly':   $unit = 'month'; $value = 2; break;
                case 'quarterly':   $unit = 'month'; $value = 3; break;
                case 'half-yearly': $unit = 'month'; $value = 6; break;
                case 'yearly':      $unit = 'year'; $value = 1; break;
            }
            // Skip generation if it's not time for it yet
            if($generatedLast != '')
            {
                $runAgain = strtotime(date('Y-m-d', $generatedLast)." +".$value." ".$unit);
                if($runAgain > time()) {
                    continue;
                }
            }

            $invoiceDate = time();
            $performanceDate = time();

            if($objInvoiceGenerations->fixedPositions)
            {
                $servicePositions   = $objInvoiceGenerations->servicePositions;
                $productPositions   = $objInvoiceGenerations->productPositions;
                $hourPositions      = $objInvoiceGenerations->hourPositions;
            }
            else
            {
                if($generatedLast == '') {
                    $generatedLast = strtotime(date('Y-m-d', time())." -".$value." ".$unit);
                }

                // Services
                $objServices = $this->Database->prepare("
                    SELECT s.id, s.unit, s.period, s.lastGeneratedOnInvoice
                    FROM tl_li_service AS s
                    WHERE s.toCustomer = ?
                        AND s.startDate <= ?
                        AND s.endDate >= ?
                        AND s.repetition = 1
                ")->execute(
                    $objInvoiceGenerations->toCustomer,
                    time(),
                    time()
                );

                $services = array();
                while($objServices->next() != null) {
                    // Skip if it is not yet time to generate on an invoice
                    if($objServices->lastGeneratedOnInvoice != '') {
                        if(strtotime(date('Y-m-d', $objServices->lastGeneratedOnInvoice)." +".$objServices->period." month") > time()) {
                            continue;
                        }
                    }

                    $services[] = array(
                        'quantity' => 1,
                        'unit' => $objServices->unit,
                        'item' => $objServices->id,
                        'title' => ''
                    );

                    // Update lastGeneratedOnInvoice flag
                    $this->Database->prepare("
                        UPDATE tl_li_service
                        SET lastGeneratedOnInvoice = ?
                        WHERE id = ?
                    ")->execute(
                        time(),
                        $objServices->id
                    );
                }
                $servicePositions = serialize($services);

                // Products
                $objProducts = $this->Database->prepare("
                    SELECT p.id, SUM(pc.number) AS quantity, p.unit
                    FROM tl_li_product AS p
                    INNER JOIN tl_li_product_to_customer AS pc
                        ON p.id = pc.toProduct
                    WHERE pc.toCustomer = ?
                        AND pc.saleDate <= ?
                        AND pc.saleDate > ?
                    GROUP BY p.id
                ")->execute(
                    $objInvoiceGenerations->toCustomer,
                    time(),
                    $generatedLast
                );
                
                $products = array();
                while($objProducts->next() != null) {
                    $products[] = array(
                        'quantity' => $objProducts->quantity,
                        'unit' => $objProducts->unit,
                        'item' => $objProducts->id,
                        'title' => ''
                    );
                }
                $productPositions = serialize($products);

                // Hours
                $hours = array();
                $hourPositions = serialize($hours);
                $objHours = $this->Database->prepare("
                	SELECT wp.id, (SUM(wh.hours) + SUM(wh.minutes) / 60) AS quantity
					FROM tl_li_work_package AS wp
					INNER JOIN tl_li_working_hour AS wh
						ON wp.id = wh.toWorkPackage
					WHERE wp.toCustomer = ?
                        AND wh.entryDate <= ?
                        AND wh.entryDate > ?
                    GROUP BY wp.id
                ")->execute(
					$objInvoiceGenerations->toCustomer,
                    time(),
                    $generatedLast
				);
				
				$hours = array();
                while($objHours->next() != null) {
                    $hours[] = array(
                        'quantity' => $objHours->quantity,
                        'unit' => 'hour',
                        'item' => $objHours->id,
                        'title' => ''
                    );
                }
                $hourPositions = serialize($hours);
				
				// Skip generation when no positions are available
				if($objServices->numRows == 0 && $objProducts->numRows == 0 && $objHours->numRows == 0) {
                    continue;
                }
            }

            $invoiceId = $this->Database->prepare("
                INSERT INTO tl_li_invoice(tstamp, toCustomer, toCategory, invoiceDate, performanceDate, currency, maturity, isSingular, isOut,
                    enableGeneration, headline, toTemplate, toAddress, descriptionBefore, servicePositions, productPositions, hourPositions, discount, earlyPaymentDiscount, descriptionAfter,
                    published)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ")->execute(
                time(),
                $objInvoiceGenerations->toCustomer,
                $objInvoiceGenerations->toCategory,
                $invoiceDate,
                $performanceDate,
                $objInvoiceGenerations->currency,
                $objInvoiceGenerations->maturity,
                0,
                1,
                1,
                $objInvoiceGenerations->headline,
                $objInvoiceGenerations->toTemplate,
                $objInvoiceGenerations->toAddress,
                $objInvoiceGenerations->descriptionBefore,
                $servicePositions,
                $productPositions,
                $hourPositions,
                $objInvoiceGenerations->discount,
                $objInvoiceGenerations->earlyPaymentDiscount,
                $objInvoiceGenerations->descriptionAfter,
                $objInvoiceGenerations->publishImmediately
            )->insertId;

            $invoiceNumber = $this->replaceInsertTags($GLOBALS['TL_CONFIG']['li_crm_invoice_number_generation']);
            $invoiceTitle = $GLOBALS['TL_LANG']['tl_li_invoice']['generatedInvoiceName'].$invoiceNumber;

            $invoice = new \LiCRM\Invoice();
            $invoiceAlias = $invoice->generateAliasWithoutDC($invoiceTitle, $invoiceId);

            $this->Database->prepare("
                UPDATE tl_li_invoice
                SET title = ?,
                    alias = ?,
                    invoiceNumber = ?
                WHERE id = ?
            ")->execute(
                $invoiceTitle,
                $invoiceAlias,
                $invoiceNumber,
                $invoiceId
            );

            $invoice->printInvoiceAsPDF($invoiceId);
			
			if($objInvoiceGenerations->sendImmediately) {
				$invoice->sendInvoice($invoiceId);
			}

            // Update generated last date
            $this->Database->prepare("
                UPDATE tl_li_invoice_generation
                SET generatedLast = ?
                WHERE id = ?
            ")->execute(
                time(),
                $objInvoiceGenerations->id
            );

        }
    }

    public function getServiceOptions(\MultiColumnWizard $mcw)
    {
        $options = array();
        $objInvoice = $this->Database->prepare("
            SELECT toCustomer, currency
            FROM tl_li_invoice_generation
            WHERE id = ?
        ")->limit(1)->execute($mcw->currentRecord);
        $objServices = $this->Database->prepare("
            SELECT id, title
            FROM tl_li_service AS s
            WHERE toCustomer = ?
              AND currency = ?
        ")->execute($objInvoice->toCustomer, $objInvoice->currency);
        while ($objServices->next())
        {
            $options[$objServices->id] = $objServices->title;
        }
        return $options;
    }

    public function getProductOptions(\MultiColumnWizard $mcw)
    {
        $options = array();
        $objInvoice = $this->Database->prepare("
            SELECT toCustomer, currency
            FROM tl_li_invoice_generation
            WHERE id = ?
        ")->limit(1)->execute($mcw->currentRecord);
        $objProducts = $this->Database->prepare("
            SELECT p.id, p.title
            FROM tl_li_product AS p
            INNER JOIN tl_li_product_to_customer AS ptc
                ON ptc.toProduct = p.id
            WHERE ptc.toCustomer = ?
              AND p.currency = ?
        ")->execute($objInvoice->toCustomer, $objInvoice->currency);
        while ($objProducts->next())
        {
            $options[$objProducts->id] = $objProducts->title;
        }
        return $options;
    }

    public function getHourOptions(\MultiColumnWizard $mcw)
    {
        $options = array();
        $objInvoice = $this->Database->prepare("
            SELECT toCustomer, currency
            FROM tl_li_invoice_generation
            WHERE id = ?
        ")->limit(1)->execute($mcw->currentRecord);
        $objHours = $this->Database->prepare("
            SELECT wp.id, wp.title, SUM(wh.hours) AS sumHours, SUM(wh.minutes) AS sumMinutes
            FROM tl_li_work_package AS wp
            INNER JOIN tl_li_working_hour AS wh
                ON wh.toWorkPackage = wp.id
            INNER JOIN tl_li_hourly_wage AS hw
                ON hw.id = wp.toHourlyWage
            WHERE wp.toCustomer = ?
                AND hw.currency = ?
                AND wp.printOnInvoice = 1
            GROUP BY wp.id
        ")->execute($objInvoice->toCustomer, $objInvoice->currency);
        while ($objHours->next())
        {
            $hours = $objHours->sumHours;
            $minutes = $objHours->sumMinutes;

            $hours = \LiCRM\Invoice::getTotalHours($objHours->sumHours, $objHours->sumMinutes);

            $options[$objHours->id] = $objHours->title.' ('.$hours.')';
        }
        return $options;
    }
}