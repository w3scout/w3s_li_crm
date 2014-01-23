<?php

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      Darko Selesi <hallo@w3scouts.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace W3S\LiCRM;

/**
 * Class Invoice
 */
class Invoice extends \BackendModule
{
	/**
	 * Template
	 */
	protected $strTemplate = 'be_invoice';

	/**
	 * Generate the module
	 * @return string
	 */
	public function generate()
	{
		parent::generate();

		$key = \Input::get('key');
		$id = \Input::get('id');

        if($key == 'paid')
        {
            $this->Template->success = $this->invoicePaid($id);
        }
		elseif($key == 'print')
		{
			$this->Template->filePath = $this->printInvoiceAsPDF($id);
		}
		elseif($key == 'html')
		{
			$this->generateHtmlInvoice($id);
		}
		elseif ($key == 'reports')
		{
			$this->Template->graphData = $this->generateReports();
		}
		elseif ($key == 'send')
		{
			$this->Template->dispatchSuccessful = $this->sendInvoice($id);
		}
		elseif($key == 'generation')
		{
			$generationId = $this->buildGeneration($id);
			$this->redirect('contao/main.php?do=li_invoices&table=tl_li_invoice_generation&act=edit&id='.$generationId.'&rt='.REQUEST_TOKEN);
		}
		elseif ($key == 'pdf')
		{
			// Return the file and do not render the template
			$this->returnFile($id);
		}

		$this->Template->id = $id;
		$this->Template->key = $key;

		return $this->Template->parse();
	}

	/**
	 * Generate module
	 */
	protected function compile(){}

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
		    FROM tl_li_invoice
		    WHERE alias = ?
		")->execute($varValue);

		// Check whether the news alias exists
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
            FROM tl_li_invoice
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

	public function renderLabel($row, $label)
	{
		if ($row['isOut'] == '1')
		{
			$icon = "<img src=\"system/modules/li_crm/assets/income.png\" alt=\"".$GLOBALS['TL_LANG']['tl_li_invoice']['income']."\" style=\"vertical-align:-3px;\" /> ";
		}
		else
		{
			$icon = "<img src=\"system/modules/li_crm/assets/expense.png\" alt=\"".$GLOBALS['TL_LANG']['tl_li_invoice']['expense']."\" style=\"vertical-align:-3px;\" /> ";
		}
		$currencyHelper = new CurrencyHelper();
		$symbol = $currencyHelper->getSymbolOfCode($row['currency']);
		return $icon.$this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $row['invoiceDate'])." - ".$row['title']." (".$this->getFormattedNumber($row['price'])." ".$symbol.")";
	}

	public function getInvoiceCount($insertConfig)
	{
		$arrSplit = explode('::', $insertConfig);

		if ($arrSplit[0] == 'countInvoices')
		{
			if (isset($arrSplit[1]))
			{
				$objInvoice = $this->Database->prepare("
				    SELECT COUNT(id) AS countInvoices
				    FROM tl_li_invoice
				    WHERE isOut = '1'")
                    ->limit(1)
                    ->executeUncached();

                $count = $objInvoice->countInvoices;

                if (!empty($GLOBALS['TL_CONFIG']['li_crm_invoice_number_generation_start']))
				{
					$count += $GLOBALS['TL_CONFIG']['li_crm_invoice_number_generation_start'];
				}
				return str_pad($count, $arrSplit[1], '0', STR_PAD_LEFT);
			}
			return false;
		}
		return false;
	}

	public function getAddressOptions(\DataContainer $dc)
	{
		$addresses = array();
		$objAddresses = $this->Database->prepare("
		    SELECT id, firstname, lastname
		    FROM tl_address
		    WHERE isBillingAddress = '1'
		        AND pid = ?
		")->execute($dc->activeRecord->toCustomer);
		while ($objAddresses->next())
		{
			$addresses[$objAddresses->id] = $objAddresses->firstname." ".$objAddresses->lastname;
		}
		return $addresses;
	}

	public function getUnitOptions(\MultiColumnWizard $mcw)
	{
        $this->loadLanguageFile('tl_li_invoice');
		$unit_options = array(
				'unit' => $GLOBALS['TL_LANG']['tl_li_invoice']['units']['unit'],
				'hour' => $GLOBALS['TL_LANG']['tl_li_invoice']['units']['hour'],
				'month' => $GLOBALS['TL_LANG']['tl_li_invoice']['units']['month'],
				'year' => $GLOBALS['TL_LANG']['tl_li_invoice']['units']['year']
		);
		return $unit_options;
	}

	public function getServiceOptions(\MultiColumnWizard $mcw)
	{
		$options = array();
		$objInvoice = $this->Database->prepare("
		    SELECT toCustomer, currency
		    FROM tl_li_invoice
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
		    FROM tl_li_invoice
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
		    FROM tl_li_invoice
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
			$hours = Invoice::getTotalHours($objHours->sumHours, $objHours->sumMinutes);

			$options[$objHours->id] = $objHours->title.' ('.$hours.')';
		}
		return $options;
	}

	public function printInvoiceAsPDF($id)
	{
		// Log process
		$this->log('Generate new pdf invoice', 'Generate invoice with id '.$id, TL_FILES);

		$data           = $this->getInvoiceData($id,"pdf");
        $strHtml        = $data['html'];

        $invoiceNumber  = $data['invoiceNumber'];
        $fullNetto      = $data['fullNetto'];
		
		$objInvoice = $this->Database->prepare("
            SELECT i.alias, i.invoiceDate, t.basePath, t.periodFolder
            FROM tl_li_invoice AS i
            INNER JOIN tl_li_invoice_template AS t
                ON i.toTemplate = t.id
            WHERE i.id = ?
        ")->limit(1)->execute($id);

        $dompdf = new \ContaoDOMPDF();
        $dompdf->set_paper('a4');
        $dompdf->set_base_path(TL_ROOT);
		//problem with german umlauts> deleted iconv():No Problem with german umlauts: correct pdf-rendering
        //$dompdf->load_html(iconv("UTF-8", "CP1252", $strHtml));
		$dompdf->load_html($strHtml);
		$dompdf->render();

        $strPDF = $dompdf->output();

		// Generate export path
        $root = TL_ROOT."/";
        $objResult = \FilesModel::findByUuid($objInvoice->basePath);

        $basePath = $objResult->path."/";

        $periodFolder = "";
		if ($objInvoice->periodFolder != '')
		{
			if ($objInvoice->periodFolder == 'daily')
			{
                $periodFolder = date('Y-z', $objInvoice->invoiceDate).'/';
			}
			elseif ($objInvoice->periodFolder == 'weekly')
			{
                $periodFolder = date('Y-W', $objInvoice->invoiceDate).'/';
			}
			elseif ($objInvoice->periodFolder == 'monthly')
			{
                $periodFolder = date('Y-m', $objInvoice->invoiceDate).'/';
			}
			elseif ($objInvoice->periodFolder == 'yearly')
			{
                $periodFolder = date('Y', $objInvoice->invoiceDate).'/';
			}
		}

		if (!file_exists($root.$basePath.$periodFolder))
		{
			mkdir($root.$basePath.$periodFolder, 0777, true);
		}

        $file = $objInvoice->alias.'.pdf';
		$exportFile = $root.$basePath.$periodFolder.$file;

		// Save pdf as file
		$pdfInvoice = fopen($exportFile, 'w');
		fwrite($pdfInvoice, $strPDF);
		fclose($pdfInvoice);

		$templateLink = substr($exportFile, 2);
		$filePath = $basePath.$periodFolder.$file;

		//Synchronize the file system with the database
		$objFile = \Dbafs::addResource($filePath);

		if($objFile){
			$this->Database->prepare("
				UPDATE tl_li_invoice
				SET file = ?, invoiceNumber = ?, price = ?
				WHERE id = ?
			")->execute($objFile->uuid, $invoiceNumber, $fullNetto, $id);

			// Return link to template
			return $templateLink;
		}
		return null;
	}

	private function getInvoiceData($id,$type)
	{
        $this->import('Encryption');

		// Get data
		$objInvoice = $this->Database->prepare("
            SELECT i.title,
                i.alias,
                i.invoiceNumber,
                i.invoiceDate,
                i.performanceDate,
                i.toCustomer,
                m.customerNumber,
                i.currency,
                i.toAddress,
                i.maturity,
                i.descriptionBefore,
                i.discount,
                i.withoutTaxes,
                i.earlyPaymentDiscount,
                i.descriptionAfter,
                i.isOut,
                i.headline,
                i.servicePositions,
                i.productPositions,
                i.hourPositions,
                t.title AS templateTitle,
                t.invoice_template,
                t.logo,
                t.maturity AS templateMaturity,
                t.descriptionBefore AS templateDescriptionBefore,
                t.descriptionAfter AS templateDescriptionAfter,
                t.basePath,
                t.periodFolder
            FROM tl_li_invoice AS i
            INNER JOIN tl_li_invoice_template AS t
                ON i.toTemplate = t.id
            LEFT JOIN tl_member AS m
                ON i.toCustomer = m.id
            WHERE i.id = ?
        ")->limit(1)->execute($id);

        $objCustomerAddress = $this->Database->prepare("
            SELECT company, firstname, lastname, street, postal, city, gender, country, isFriend
            FROM tl_address
            WHERE id=?
        ")->limit(1)->execute($objInvoice->toAddress);

		// Load language file
		$this->loadLanguageFile('tl_member');
		$this->loadLanguageFile('tl_li_invoice');
        $this->loadLanguageFile('tl_li_company_settings');

		// Import required systems
		$this->import('BackendUser', 'User');

		$templateFile = $objInvoice->invoice_template;

        $countries = $this->getCountries();
        $country = $objCustomerAddress->country != $GLOBALS['TL_CONFIG']['li_crm_company_country'] ? $countries[$objCustomerAddress->country] : '';

        $invoiceNumber = $objInvoice->invoiceNumber != '' ? $objInvoice->invoiceNumber : $this->replaceInsertTags($GLOBALS['TL_CONFIG']['li_crm_invoice_number_generation'],false);

        $objLogo = \FilesModel::findByUuid($objInvoice->logo);

        $template = array(
            'logo'                      => $objLogo->path,
            'company_name'              => $GLOBALS['TL_CONFIG']['li_crm_company_name'],
            'company_street'            => $GLOBALS['TL_CONFIG']['li_crm_company_street'],
            'company_postal'            => $this->Encryption->decrypt($GLOBALS['TL_CONFIG']['li_crm_company_postal']),
            'company_city'              => $GLOBALS['TL_CONFIG']['li_crm_company_city'],
            'company_phone'             => $this->Encryption->decrypt($GLOBALS['TL_CONFIG']['li_crm_company_phone']),
            'company_fax'               => $this->Encryption->decrypt($GLOBALS['TL_CONFIG']['li_crm_company_fax']),
            'company_email'             => $GLOBALS['TL_CONFIG']['li_crm_company_email'],
            'company_website'           => $GLOBALS['TL_CONFIG']['li_crm_company_website'],

            'company_tax_number'        => $GLOBALS['TL_CONFIG']['li_crm_company_tax_number'],
            'company_ustid'             => $GLOBALS['TL_CONFIG']['li_crm_company_ustid'],

            'customer_number'           => $objInvoice->customerNumber,
            'customer_company'          => $objCustomerAddress->company,
            'customer_firstname'        => $objCustomerAddress->firstname,
            'customer_lastname'         => $objCustomerAddress->lastname,
            'customer_street'           => $objCustomerAddress->street,
            'customer_postal'           => $objCustomerAddress->postal,
            'customer_city'             => $objCustomerAddress->city,
            'customer_country'          => $country,

            'invoice_date'              => date($GLOBALS['TL_CONFIG']['dateFormat'], $objInvoice->invoiceDate),
            'invoice_number'            => $invoiceNumber,

            'title'                     => $objInvoice->headline != '' ? $objInvoice->headline : $GLOBALS['TL_LANG']['tl_li_invoice']['invoice_legend'],
            'introduction'              => $objCustomerAddress->gender == 'male' || $objCustomerAddress->gender == '' ?
					($objCustomerAddress->isFriend && $GLOBALS['TL_LANG']['tl_li_invoice']['introduction_male_friend'] ? sprintf($GLOBALS['TL_LANG']['tl_li_invoice']['introduction_male_friend'],$objCustomerAddress->firstname) : sprintf($GLOBALS['TL_LANG']['tl_li_invoice']['introduction_male'],$objCustomerAddress->lastname))  :
					($objCustomerAddress->isFriend && $GLOBALS['TL_LANG']['tl_li_invoice']['introduction_female_friend'] ? sprintf($GLOBALS['TL_LANG']['tl_li_invoice']['introduction_female_friend'],$objCustomerAddress->firstname) : sprintf($GLOBALS['TL_LANG']['tl_li_invoice']['introduction_female'],$objCustomerAddress->lastname)),

            'early_payment_discount'    => $objInvoice->earlyPaymentDiscount,

            'performance_date_remark'   => $objInvoice->invoiceDate == $objInvoice->performanceDate ? $GLOBALS['TL_LANG']['tl_li_invoice']['performance_is_invoice_date'] : sprintf($GLOBALS['TL_LANG']['tl_li_invoice']['performance_date_at'], date($GLOBALS['TL_CONFIG']['dateFormat'], $objInvoice->performanceDate)),
            'account_number'            => $this->Encryption->decrypt($GLOBALS['TL_CONFIG']['li_crm_account_number']),
            'bank_code'                 => $this->Encryption->decrypt($GLOBALS['TL_CONFIG']['li_crm_bank_code']),
            'iban'                      => $this->Encryption->decrypt($GLOBALS['TL_CONFIG']['li_crm_iban']),
            'bic'                       => $this->Encryption->decrypt($GLOBALS['TL_CONFIG']['li_crm_bic']),
            'bank'                      => $this->Encryption->decrypt($GLOBALS['TL_CONFIG']['li_crm_bank']),

            'greeting' => sprintf($GLOBALS['TL_LANG']['tl_li_invoice']['greeting'], $GLOBALS['TL_CONFIG']['li_crm_company_name'])
        );

        if($GLOBALS['TL_CONFIG']['websitePath'] == '') {
            $template['base'] = "/";
        } else {
            if(substr($GLOBALS['TL_CONFIG']['websitePath'], -1) == "/") {
                $template['base'] = $GLOBALS['TL_CONFIG']['websitePath'];
            } else {
                $template['base'] = $GLOBALS['TL_CONFIG']['websitePath']."/";
            }
        }

		$currencyHelper = new CurrencyHelper();
		$symbol = $currencyHelper->getSymbolOfCode($objInvoice->currency);

		$rowCounter = 1;
		$fullNetto = 0;
		$fullTaxes = 0;
		$taxes = array();

        $htmlPositions = "";

		$services = unserialize($objInvoice->servicePositions);
		if(is_array($services)) {
            foreach ($services as $service)
            {
                if (empty($service['quantity']))
                {
                    continue;
                }

                $objService = $this->Database->prepare("
                    SELECT s.title, s.price, t.rate AS taxRate
                    FROM tl_li_service AS s
                    INNER JOIN tl_li_tax AS t
                        ON s.toTax = t.id
                    WHERE s.id = ?
                ")->execute($service['item']);

                $position_total_price = $service['quantity'] * $objService->price;

                if (!array_key_exists($objService->taxRate, $taxes))
                {
                    $taxes[$objService->taxRate] = $position_total_price;
                }
                else
                {
                    $taxes[$objService->taxRate] += $position_total_price;
                }

                $fullNetto += $service['quantity'] * $objService->price;

                $title = $service['title'] != '' ? $service['title'] : $objService->title;

                $htmlPositions .= '<tr class="'.$this->getOddEven($rowCounter).'">';
                $htmlPositions .= '<td class="quantity">'.$service['quantity'].'</td>';
                $htmlPositions .= '<td class="unit">'.$GLOBALS['TL_LANG']['tl_li_invoice']['units'][$service['unit']].'</td>';
                $htmlPositions .= '<td class="label">'.$title.'</td>';
                $htmlPositions .= '<td class="unit_price price">'.$this->getFormattedNumber($objService->price).' '.$symbol.'</td>';
                $htmlPositions .= '<td class="total_price price">'.$this->getFormattedNumber($position_total_price).' '.$symbol.'</td>';
                $htmlPositions .= '</tr>';

                $rowCounter++;
            }
        }

		$products = unserialize($objInvoice->productPositions);
        if(is_array($products)) {
            foreach ($products as $product)
            {
                if (empty($product['quantity']))
                {
                    continue;
                }
                $objProduct = $this->Database->prepare("
                    SELECT p.title, p.price, t.rate AS taxRate
                    FROM tl_li_product AS p
                    INNER JOIN tl_li_tax AS t
                        ON p.toTax = t.id
                    WHERE p.id = ?
                ")->execute($product['item']);

                $position_total_price = $product['quantity'] * $objProduct->price;

                if (!array_key_exists($objProduct->taxRate, $taxes))
                {
                    $taxes[$objProduct->taxRate] = $position_total_price;
                }
                else
                {
                    $taxes[$objProduct->taxRate] += $position_total_price;
                }

                $fullNetto += $product['quantity'] * $objProduct->price;

                $title = $product['title'] != '' ? $product['title'] : $objProduct->title;

                $htmlPositions .= '<tr class="'.$this->getOddEven($rowCounter).'">';
                $htmlPositions .= '<td class="quantity">'.$product['quantity'].'</td>';
                $htmlPositions .= '<td class="unit">'.$GLOBALS['TL_LANG']['tl_li_invoice']['units'][$product['unit']].'</td>';
                $htmlPositions .= '<td class="label">'.$title.'</td>';
                $htmlPositions .= '<td class="unit_price price">'.$this->getFormattedNumber($objProduct->price).' '.$symbol.'</td>';
                $htmlPositions .= '<td class="total_price price">'.$this->getFormattedNumber($position_total_price).' '.$symbol.'</td>';
                $htmlPositions .= '</tr>';

                $rowCounter++;
            }
        }

		$hours = unserialize($objInvoice->hourPositions);
        if(is_array($hours)) {
            foreach ($hours as $hour)
            {
                if (empty($hour['item']))
                {
                    continue;
                }
                $objHour = $this->Database->prepare("
                    SELECT wp.title, hw.wage, t.rate AS taxRate
                    FROM tl_li_work_package AS wp
                    INNER JOIN tl_li_hourly_wage AS hw
                        ON wp.toHourlyWage = hw.id
                    INNER JOIN tl_li_tax AS t
                        ON hw.toTax = t.id
                    WHERE wp.id = ?
                ")->execute($hour['item']);

                $position_total_price = $hour['quantity'] * $objHour->wage;

                if (!array_key_exists($objHour->taxRate, $taxes))
                {
                    $taxes[$objHour->taxRate] = $position_total_price;
                }
                else
                {
                    $taxes[$objHour->taxRate] += $position_total_price;
                }

                $fullNetto += $hour['quantity'] * $objHour->wage;

                $title = $hour['title'] != '' ? $hour['title'] : $objHour->title;

                $htmlPositions .= '<tr class="'.$this->getOddEven($rowCounter).'">';
                $htmlPositions .= '<td class="quantity">'.$hour['quantity'].'</td>';
                $htmlPositions .= '<td class="unit">'.$GLOBALS['TL_LANG']['tl_li_invoice']['units']['hour'].'</td>';
                $htmlPositions .= '<td class="label">'.$title.'</td>';
                $htmlPositions .= '<td class="unit_price price">'.$this->getFormattedNumber($objHour->wage).' '.$symbol.'</td>';
                $htmlPositions .= '<td class="total_price price">'.$this->getFormattedNumber($position_total_price).' '.$symbol.'</td>';
                $htmlPositions .= '</tr>';

                $rowCounter++;
            }
        }

        $discount = unserialize($objInvoice->discount);
        if(!empty($discount['value']))
        {
            $htmlPositions .= '<tr class="'.$this->getOddEven($rowCounter).'">';
            $htmlPositions .= '<td class="spacer" colspan="5"> </td>';
            $htmlPositions .= '</tr>';
            $rowCounter++;

            if($discount['unit'] == 'percent')
            {
                $discountValue = $fullNetto * $discount['value'] / 100;

                $htmlPositions .= '<tr class="'.$this->getOddEven($rowCounter).'">';
                $htmlPositions .= '<td class="quantity"> </td>';
                $htmlPositions .= '<td class="unit"> </td>';
                $htmlPositions .= '<td class="label">'.$discount['value'].'% '.$GLOBALS['TL_LANG']['tl_li_invoice']['discount'][0].'</td>';
                $htmlPositions .= '<td class="unit_price price"> </td>';
                $htmlPositions .= '<td class="total_price price">- '.$this->getFormattedNumber($discountValue).' '.$symbol.'</td>';
                $htmlPositions .= '</tr>';

                $rowCounter++;

                $fullNetto -= $discountValue;
            }
            else
            {
                $htmlPositions .= '<tr class="'.$this->getOddEven($rowCounter).'">';
                $htmlPositions .= '<td class="quantity"> </td>';
                $htmlPositions .= '<td class="unit"> </td>';
                $htmlPositions .= '<td class="label">'.$GLOBALS['TL_LANG']['tl_li_invoice']['discount'][0].'</td>';
                $htmlPositions .= '<td class="unit_price price"> </td>';
                $htmlPositions .= '<td class="total_price price">- '.$this->getFormattedNumber($discount['value']).' '.$symbol.'</td>';
                $htmlPositions .= '</tr>';

                $rowCounter++;

                $fullNetto -= $discount['value'];
            }
        }

		/*$htmlPositions .= '<tr class="'.$this->getOddEven($rowCounter).'">';
		$htmlPositions .= '<td class="spacer" colspan="5"> </td>';
		$htmlPositions .= '</tr>';
		$rowCounter++;*/

		//for a better contrast in the invoice-layout : total (and if requested, total_netto) always on an 'odd' row
		$htmlPositions .= '<tr class="even">';
		$htmlPositions .= '<td class="spacer" colspan="5"> </td>';
		$htmlPositions .= '</tr>';
		$rowCounter = 0;

        if(!$objInvoice->withoutTaxes) {
            $htmlPositions .= '<tr class="'.$this->getOddEven($rowCounter).' total start">';
            $htmlPositions .= '<td class="amount netto" colspan="4">'.$GLOBALS['TL_LANG']['tl_li_invoice']['total_netto'].'</td><td class="price">'.$this->getFormattedNumber($fullNetto).' '.$symbol.'</td>';
            $htmlPositions .= '</tr>';
            $rowCounter++;
        } else {
            $htmlPositions .= '<tr class="'.$this->getOddEven($rowCounter).' total without">';
            $htmlPositions .= '<td class="amount" colspan="4">'.$GLOBALS['TL_LANG']['tl_li_invoice']['total'].'</td><td class="price">'.$this->getFormattedNumber($fullNetto).' '.$symbol.'</td>';
            $htmlPositions .= '</tr>';
            $rowCounter++;
        }

        if(!$objInvoice->withoutTaxes) {
            ksort($taxes);
            foreach ($taxes as $tax => $price)
            {
                // Without discount
                if(empty($discount['value'])) {
                    $taxPrice = $price * $tax / 100;
                // With discount
                } else {
                    // Percentage discount
                    if($discount['unit'] == 'percent') {
                        $taxPrice = ($price - $price * $discount['value'] / 100) * $tax / 100;
                    // Absolute discount
                    } else {
                        $taxPrice = ($price - $discount['value'] / count($taxes)) * $tax / 100;
                    }
                }

                $fullTaxes += $taxPrice;
                $htmlPositions .= '<tr class="total '.$this->getOddEven($rowCounter).'">';
                $htmlPositions .= '<td class="amount tax" colspan="4">'.$tax.'% '.$GLOBALS['TL_LANG']['tl_li_invoice']['tax'].'</td><td class="price">'.$this->getFormattedNumber($taxPrice).' '.$symbol.'</td>';
                $htmlPositions .= '</tr>';
                $rowCounter++;
            }

            $htmlPositions .= '<tr class="'.$this->getOddEven($rowCounter).' total end">';
            $htmlPositions .= '<td class="amount brutto" colspan="4">'.$GLOBALS['TL_LANG']['tl_li_invoice']['total_brutto'].'</td><td class="price">'.$this->getFormattedNumber($fullNetto + $fullTaxes).' '.$symbol.'</td>';
            $htmlPositions .= '</tr>';
        }

		$descriptionBefore = '';
		$descriptionAfter = '';
		if ($objInvoice->descriptionBefore != '')
		{
			$descriptionBefore = $objInvoice->descriptionBefore;
		}
		elseif ($objInvoice->templateDescriptionBefore != '')
		{
			$descriptionBefore = $objInvoice->templateDescriptionBefore;
		}

		if ($objInvoice->descriptionAfter != '')
		{
			$descriptionAfter = $objInvoice->descriptionAfter;
		}
		elseif ($objInvoice->templateDescriptionAfter != '')
		{
			$descriptionAfter = $objInvoice->templateDescriptionAfter;
		}

		if ($objInvoice->maturity != '' && $objInvoice->maturity != 0)
		{
			$maturityDays = $objInvoice->maturity;
		}
		elseif ($objInvoice->templateMaturity != '' && $objInvoice->templateMaturity != 0)
		{
			$maturityDays = $objInvoice->templateMaturity;
		}
		elseif (!empty($GLOBALS['TL_CONFIG']['li_crm_invoice_maturity']))
		{
			$maturityDays = $GLOBALS['TL_CONFIG']['li_crm_invoice_maturity'];
		}

		$maturity_remark = '';
		if (!empty($maturityDays))
		{
			$maturity_remark = sprintf(($objCustomerAddress->isFriend && $GLOBALS['TL_LANG']['tl_li_invoice']['maturity_remark_friend'] ? $GLOBALS['TL_LANG']['tl_li_invoice']['maturity_remark_friend'] : $GLOBALS['TL_LANG']['tl_li_invoice']['maturity_remark']), $maturityDays);
		}

        $template['description_before'] = $descriptionBefore;
        $template['positions']          = $htmlPositions;
        $template['description_after']  = $descriptionAfter;
        $template['maturity_remark']    = $maturity_remark;

        $template['root_path']          = $type == 'pdf' ? TL_ROOT.'/' : null;

		ob_start();    
    header("Content-Type: text/html; charset=utf-8");
		include ($this->getTemplate($templateFile, 'html5'));
		$html = ob_get_contents();
		ob_end_clean();

		return array(
            'html' => $html,
            'invoiceNumber' => $invoiceNumber,
            'fullNetto' => $fullNetto
        );
	}

	private function generateReports()
	{
		$graphData = array(
            'month',
            'year'
		);

		// Month
		$currentMonth = date('m');
		$currentYear = date('Y');

		$startYear = ($currentMonth - 9 > 0) ? $currentYear : $currentYear - 1;
		$startMonth = ($currentMonth - 9 > 0) ? $currentMonth - 9 : 12 - (($currentMonth - 9) * -1);

		$monthData = array();
		$tmpMonthData = array();

		if ($currentMonth - 9 > 0)
		{
			$monthInSql = "SELECT MONTH(FROM_UNIXTIME(invoiceDate)) AS currentMonth, YEAR(FROM_UNIXTIME(invoiceDate)) AS currentYear, SUM(price) AS sumPrice
					       FROM tl_li_invoice
					       WHERE isOut = ''
					       	AND MONTH(FROM_UNIXTIME(invoiceDate)) >= ?
					 		AND MONTH(FROM_UNIXTIME(invoiceDate)) <= ? 
					 		AND YEAR(FROM_UNIXTIME(invoiceDate)) = ? 
					   	   GROUP BY MONTH(FROM_UNIXTIME(invoiceDate))
					   	   ORDER BY YEAR(FROM_UNIXTIME(invoiceDate)), MONTH(FROM_UNIXTIME(invoiceDate))";
			$monthOutSql = "SELECT MONTH(FROM_UNIXTIME(invoiceDate)) AS currentMonth, YEAR(FROM_UNIXTIME(invoiceDate)) AS currentYear, SUM(price) AS sumPrice
							FROM tl_li_invoice
							WHERE isOut = '1'
								AND MONTH(FROM_UNIXTIME(invoiceDate)) >= ?
					 			AND MONTH(FROM_UNIXTIME(invoiceDate)) <= ?
					 			AND YEAR(FROM_UNIXTIME(invoiceDate)) = ?
					 		GROUP BY MONTH(FROM_UNIXTIME(invoiceDate))
					 		ORDER BY YEAR(FROM_UNIXTIME(invoiceDate)), MONTH(FROM_UNIXTIME(invoiceDate))";

			$objMonthIn = $this->Database->prepare($monthInSql)->execute($startMonth, $currentMonth, $currentYear);
			$objMonthOut = $this->Database->prepare($monthOutSql)->execute($startMonth, $currentMonth, $currentYear);
		}
		else
		{
			$monthInSql = "SELECT MONTH( FROM_UNIXTIME( invoiceDate ) ) AS	currentMonth , YEAR( FROM_UNIXTIME( invoiceDate ) ) AS currentYear, SUM( price ) AS sumPrice
							FROM tl_li_invoice
							WHERE isOut = ''
								AND
								(
									(MONTH( FROM_UNIXTIME( invoiceDate ) ) >= ?
									AND MONTH( FROM_UNIXTIME( invoiceDate ) ) <= 12
									AND YEAR( FROM_UNIXTIME( invoiceDate ) ) = ?)
									OR
									(MONTH( FROM_UNIXTIME( invoiceDate ) ) >= 1
									AND MONTH( FROM_UNIXTIME( invoiceDate ) ) <= ?
									AND YEAR( FROM_UNIXTIME( invoiceDate ) ) = ?)
								)
							GROUP BY MONTH( FROM_UNIXTIME( invoiceDate ) )";
			$monthOutSql = "SELECT MONTH( FROM_UNIXTIME( invoiceDate ) ) AS	currentMonth , YEAR( FROM_UNIXTIME( invoiceDate ) ) AS currentYear, SUM( price ) AS sumPrice
							FROM tl_li_invoice
							WHERE isOut = '1'
								AND
								(
									(MONTH( FROM_UNIXTIME( invoiceDate ) ) >= ?
									AND MONTH( FROM_UNIXTIME( invoiceDate ) ) <= 12
									AND YEAR( FROM_UNIXTIME( invoiceDate ) ) = ?)
									OR
									(MONTH( FROM_UNIXTIME( invoiceDate ) ) >= 1
									AND MONTH( FROM_UNIXTIME( invoiceDate ) ) <= ?
									AND YEAR( FROM_UNIXTIME( invoiceDate ) ) = ?)
								)
							GROUP BY MONTH( FROM_UNIXTIME( invoiceDate ) )";

			$objMonthIn = $this->Database->prepare($monthInSql)->execute($startMonth, $startYear, $currentMonth, $currentYear);
			$objMonthOut = $this->Database->prepare($monthOutSql)->execute($startMonth, $startYear, $currentMonth, $currentYear);
		}

		while ($objMonthIn->next() != null)
		{
			$tmpMonthData['in-'.$objMonthIn->currentYear.'-'.$objMonthIn->currentMonth] = $objMonthIn->sumPrice;
		}
		while ($objMonthOut->next() != null)
		{
			$tmpMonthData['out-'.$objMonthOut->currentYear.'-'.$objMonthOut->currentMonth] = $objMonthOut->sumPrice;
		}

		$sumIn = 0;
		$sumOut = 0;

		$countYear = $startYear;
		$countMonth = $startMonth;

		for ($i = 0; $i < 10; $i++)
		{
			$entry = array();

			$sumIn += $tmpMonthData['in-'.$countYear.'-'.$countMonth];
			$sumOut += $tmpMonthData['out-'.$countYear.'-'.$countMonth];

			$entry['in'] = $sumIn;
			$entry['out'] = $sumOut;

			$timestamp = mktime(0, 0, 0, $countMonth, 1, $countYear);
			$entry['label'] = $this->parseDate("M", $timestamp);

			$countMonth++;
			if ($countMonth > 12)
			{
				$countMonth = 1;
				$countYear++;
			}

			$monthData[] = $entry;
		}

		$graphData['month'] = $monthData;

		// Year
		$currentYear = date('Y');
		$startYear = $currentYear - 9;

		$yearData = array();
		$tmpYearData = array();

		$objYearIn = $this->Database->prepare("
            SELECT YEAR(FROM_UNIXTIME(invoiceDate)) AS year, SUM(price) AS sumPrice
            FROM tl_li_invoice
            WHERE isOut = ''
                AND YEAR(FROM_UNIXTIME(invoiceDate)) >= ?
                AND YEAR(FROM_UNIXTIME(invoiceDate)) <= ?
            GROUP BY YEAR(FROM_UNIXTIME(invoiceDate))
            ORDER BY YEAR(FROM_UNIXTIME(invoiceDate)) ASC
        ")->execute($startYear, $currentYear);
		while ($objYearIn->next() != null)
		{
			$tmpYearData['in-'.$objYearIn->year] = $objYearIn->sumPrice;
		}
		$objYearOut = $this->Database->prepare("
            SELECT YEAR(FROM_UNIXTIME(invoiceDate)) AS year, SUM(price) AS sumPrice
            FROM tl_li_invoice
            WHERE isOut = '1'
                AND YEAR(FROM_UNIXTIME(invoiceDate)) >= ?
                AND YEAR(FROM_UNIXTIME(invoiceDate)) <= ?
            GROUP BY YEAR(FROM_UNIXTIME(invoiceDate))
            ORDER BY YEAR(FROM_UNIXTIME(invoiceDate)) ASC
        ")->execute($startYear, $currentYear);
		while ($objYearOut->next() != null)
		{
			$tmpYearData['out-'.$objYearOut->year] = $objYearOut->sumPrice;
		}

		$sumIn = 0;
		$sumOut = 0;

		for ($i = $startYear; $i <= $currentYear; $i++)
		{
			$entry = array();

			$sumIn += $tmpYearData['in-'.$i];
			$sumOut += $tmpYearData['out-'.$i];

			$entry['in'] = $sumIn;
			$entry['out'] = $sumOut;
			$entry['label'] = $i;

			$yearData[] = $entry;
		}

		$graphData['year'] = $yearData;

		return $graphData;
	}
	
	private function generateHtmlInvoice($id)
	{
		$data = $this->getInvoiceData($id,"html");
        echo $data['html'];

        exit;
    }

	public function sendInvoice($id)
	{
		$objInvoice = $this->Database->prepare("
            SELECT i.invoiceDate, i.invoiceNumber, i.file, a.lastname, a.gender, a.email
            FROM tl_li_invoice AS i
            INNER JOIN tl_address AS a
                ON a.id = i.toAddress
            WHERE i.id = ?
        ")->limit(1)->execute($id);
		try
		{
			$objEmail           = new \Email();
			$objEmail->from     = $GLOBALS['TL_CONFIG']['li_crm_invoice_dispatch_from'];
			$objEmail->fromName = $GLOBALS['TL_CONFIG']['li_crm_invoice_dispatch_fromName'];
			$objEmail->subject  = $GLOBALS['TL_LANG']['tl_li_invoice']['dispatch_subject'];
			$objEmail->text     = sprintf($objInvoice->gender == 'male' || $objInvoice->gender == '' ? $GLOBALS['TL_LANG']['tl_li_invoice']['dispatch_text_male'] : $GLOBALS['TL_LANG']['tl_li_invoice']['dispatch_text_female'], $objInvoice->lastname, date($GLOBALS['TL_CONFIG']['dateFormat'], $objInvoice->invoiceDate), $GLOBALS['TL_CONFIG']['li_crm_company_name']);
			$objEmail->html     = sprintf($objInvoice->gender == 'male' || $objInvoice->gender == '' ? $GLOBALS['TL_LANG']['tl_li_invoice']['dispatch_html_male'] : $GLOBALS['TL_LANG']['tl_li_invoice']['dispatch_html_female'], $objInvoice->lastname, date($GLOBALS['TL_CONFIG']['dateFormat'], $objInvoice->invoiceDate), $GLOBALS['TL_CONFIG']['li_crm_company_name']);

			$objEmail->attachFile(TL_ROOT."/".$objInvoice->file);

            $worked = $objEmail->sendTo($objInvoice->email);

            if($worked) $this->log('Dispatch successfull: Invoice (Nr. '.$objInvoice->invoiceNumber.')', __METHOD__, TL_CRON);
		}
		catch( Exception $e )
		{
			$this->log('Dispatch error: '.$e->getMessage(), __METHOD__, TL_ERROR);
		}
		return $worked;
	}

	private function getOddEven($row)
	{
		return $row % 2 == 0 ? 'odd' : 'even';
	}

	private function returnFile($id)
	{
        $objInvoice = $this->Database->prepare("
            SELECT file AS pdfFile
            FROM tl_li_invoice
            WHERE id = ?
        ")->limit(1)->execute($id);

		$objFile = \FilesModel::findByUuid($objInvoice->pdfFile);

		$path = '../'.$objFile->path;

		$filename = basename($path);
		header('Content-type: application/pdf');
		header('Content-Disposition: inline; filename="'.$filename.'"');
		readfile($path);
	}

	public function returnFileForFrontend($id)
	{
		$this->import('FrontendUser', 'User');
		$objInvoice = $this->Database->prepare("
            SELECT toCustomer, file AS pdfFile
            FROM tl_li_invoice
            WHERE id = ?
        ")->limit(1)->execute($id);
		if ($this->User->id != '')
		{
			if ($objInvoice->toCustomer == $this->User->id)
			{
				$objFile = \FilesModel::findByUuid($objInvoice->pdfFile);
				$path = $objFile->path;
				$filename = basename($path);
				header('Content-type: application/pdf');
				header('Content-Disposition: attachment; filename="'.$filename.'"');
				readfile($path);
			}
			else
			{
				$this->sendTo403();
			}
		}
		else
		{
			$objFile = \FilesModel::findByUuid($objInvoice->pdfFile);
			$path = $objFile->path;
			$filename = basename($path);
			header('Content-type: application/pdf');
			header('Content-Disposition: attachment; filename="'.$filename.'"');
			readfile($path);
		}
	}

	public static function getTotalHours($hours, $minutes)
	{
		$minutes = Abs($minutes);
		$iHours = Floor($minutes / 60);
		$minutes = ($minutes - ($iHours * 60)) / 100;
		$tHours = $iHours + $minutes;
		if ($minutes < 0)
		{
			$tHours = $tHours * (-1);
		}
		$aHours = explode(".", $tHours);
		$iHours = $aHours[0];
		if (empty($aHours[1]))
		{
			$aHours[1] = "00";
		}
		$minutes = $aHours[1];
		if (strlen($minutes) < 2)
		{
			$minutes = $minutes."0";
		}
		return ($iHours + $hours).":".$minutes;
	}



    public function invoicePaid($id)
    {
        $objInvoice = $this->Database->prepare("
            SELECT paid
            FROM tl_li_invoice
            WHERE id = ?
        ")->limit(1)->execute($id);
        $this->Database->prepare("
            UPDATE tl_li_invoice
            SET paid = ?
            WHERE id = ?
        ")->execute(
            $objInvoice->paid == 1 ? 0 : 1,
            $id
        );
        return true;
    }
	
	private function buildGeneration($invoiceId) {
		$objInvoice = $this->Database->prepare("
			SELECT toCustomer, toCategory, title, currency, maturity,
				headline, toTemplate, toAddress, descriptionBefore, servicePositions, productPositions, hourPositions, discount, earlyPaymentDiscount, descriptionAfter
			FROM tl_li_invoice
			WHERE id = ?
		")->limit(1)->execute($invoiceId);
		
		$generationId = $this->Database->prepare("
			INSERT INTO tl_li_invoice_generation(tstamp, toCustomer, toCategory, title, currency, maturity,
				headline, toTemplate, toAddress, startDate, generationInverval, descriptionBefore, fixedPositions, servicePositions, productPositions, hourPositions, discount, earlyPaymentDiscount, descriptionAfter)
			VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
		")->execute(
			time(),
			$objInvoice->toCustomer,
			$objInvoice->toCategory,
			$objInvoice->title,
			$objInvoice->currency,
			$objInvoice->maturity,
			$objInvoice->headline,
			$objInvoice->toTemplate,
			$objInvoice->toAddress,
			strtotime('today'),
			'yearly',
			$objInvoice->descriptionBefore,
			1,
			$objInvoice->servicePositions,
			$objInvoice->productPositions,
			$objInvoice->hourPositions,
			$objInvoice->discount,
			$objInvoice->earlyPaymentDiscount,
			$objInvoice->descriptionAfter
		)->insertId;
		
		$invoiceGeneration = new InvoiceGeneration();
		$alias = $invoiceGeneration->generateAliasWithoutDC($objInvoice->title, $generationId);
		$this->Database->prepare("
			UPDATE tl_li_invoice_generation
			SET alias = ?
			WHERE id = ?
		")->execute(
			$alias,
			$generationId
		);
		
		return $generationId;
	}

	private function sendTo403()
	{
		// Add a log entry
		//$this->log('Access to page ID "'.$pageId.'" denied', 'PageError403 generate()', TL_ERROR);

		$host = \Environment::get('host');
		$accept_language = \Environment::get('httpAcceptLanguage');
		$time = time();

		// Find the matching root pages (thanks to Andreas Schempp)
		$objRootPage = $this->Database->prepare("SELECT id, dns, language, fallback FROM tl_page WHERE type='root' AND (dns=? OR dns='')".((count($accept_language) > 0) ? " AND (language IN('".implode("','", $accept_language)."') OR fallback=1)" : " AND fallback=1").(!BE_USER_LOGGED_IN ? " AND (start='' OR start<$time) AND (stop='' OR stop>$time) AND published=1" : "")." ORDER BY dns DESC".((count($accept_language) > 0) ? ", ".$this->Database->findInSet('language', array_reverse($accept_language))." DESC" : "").", sorting")->limit(1)->execute($host);

		$rootId = $objRootPage->numRows ? $objRootPage->id : 0;

		// Look for an error_403 page within the website root
		$obj403 = $this->Database->prepare("SELECT * FROM tl_page WHERE type=? AND pid=?".(!BE_USER_LOGGED_IN ? " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1" : ""))->limit(1)->execute('error_403', $rootId, $time, $time);

		// Look for a global error_403 page
		if ($obj403->numRows < 1)
		{
			$obj403 = $this->Database->prepare("SELECT * FROM tl_page WHERE type='error_403' AND pid=0".(!BE_USER_LOGGED_IN ? " AND (start='' OR start<$time) AND (stop='' OR stop>$time) AND published=1" : ""))->limit(1)->execute();
		}

		// Die if there is no page at all
		if ($obj403->numRows < 1)
		{
			header('HTTP/1.1 403 Forbidden');
			die('Forbidden');
		}

		// Generate the error page
		if (!$obj403->autoforward || $obj403->jumpTo < 1)
		{
			global $objPage;

			$objPage = $this->getPageDetails($obj403->id);
			$objHandler = new $GLOBALS['TL_PTY']['regular']();

			header('HTTP/1.1 403 Forbidden');
			$objHandler->generate($objPage);

			exit ;
		}
	}
}
