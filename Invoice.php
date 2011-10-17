<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * PHP version 5
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */

/**
 * Class Invoice
 */
class Invoice extends BackendModule
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

        $key = $this->Input->get('key');

        if ($key == 'print')
        {
            $id = $this->Input->get('id');
            $this->Template->filePath = $this->printInvoice($id);
        }
        elseif($key == 'send')
        {
            $id = $this->Input->get('id');
            $this->Template->dispatchSuccessful = $this->sendInvoice($id);
        }

        $this->Template->key = $key;

        return $this->Template->parse();
    }

    /**
     * Generate module
     */
    protected function compile()
    {
    }

    public function generateAlias($varValue, DataContainer $dc)
    {
        $autoAlias = false;

        // Generate alias if there is none
        if (!strlen($varValue)) {
            $autoAlias = true;
            $varValue = standardize($dc->activeRecord->title);
        }

        $objAlias = $this->Database->prepare("SELECT id FROM tl_li_invoice WHERE alias=?")->execute($varValue);

        // Check whether the news alias exists
        if ($objAlias->numRows > 1 && !$autoAlias) {
            throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
        }

        // Add ID to alias
        if ($objAlias->numRows && $autoAlias) {
            $varValue .= '-' . $dc->id;
        }
        return $varValue;
    }

    public function renderLabel($row, $label)
    {
        if ($row['isOut'] == '1') {
            return "<img src=\"system/modules/li_crm/icons/income.png\" alt=\"" . $GLOBALS['TL_LANG']['tl_li_invoice']['income'] . "\" style=\"vertical-align:-3px;\" /> " . $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $row['invoiceDate']) . " - " . $row['title'];
        }
        else
        {
            return "<img src=\"system/modules/li_crm/icons/expense.png\" alt=\"" . $GLOBALS['TL_LANG']['tl_li_invoice']['expense'] . "\" style=\"vertical-align:-3px;\" /> " . $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $row['invoiceDate']) . " - " . $row['title'];
        }
    }

    public function generationIcon($row, $href, $label, $title, $icon, $attributes)
    {
    	$alt = $GLOBALS['TL_LANG']['tl_li_invoice']['generate'][0];
        if ($row['enableGeneration'] && $row['isOut'] && $row['toTemplate'] && $row['toAddress']) {
            $href = '&amp;do=li_invoices&amp;key=print&amp;id=' . $row['id'];
			$title = sprintf($GLOBALS['TL_LANG']['tl_li_invoice']['generate'][1], $row['id']);
            return '<a href="' . $this->addToUrl($href) . '" title="'.$title.'"><img src="system/modules/li_crm/icons/invoice_generation.png" alt="'.$alt.'" /></a> ';
        }
        else
        {
            return '<img src="system/modules/li_crm/icons/invoice_generation_disabled.png" alt="'.$alt.'" /> ';
        }
    }

    public function dispatchIcon($row, $href, $label, $title, $icon, $attributes)
    {
    	$alt = $GLOBALS['TL_LANG']['tl_li_invoice']['dispatch'][0];
        if ($row['isOut'] && $row['file'] != '') {
            $href = '&amp;do=li_invoices&amp;key=send&amp;id=' . $row['id'];
			$title = sprintf($GLOBALS['TL_LANG']['tl_li_invoice']['dispatch'][1], $row['id']);
            return '<a href="' . $this->addToUrl($href) . '" title="'.$title.'"><img src="system/modules/li_crm/icons/invoice_send.png" alt="'.$alt.'" /></a> ';
        }
        else
        {
            return '<img src="system/modules/li_crm/icons/invoice_send_disabled.png" alt="'.$alt.'" /> ';
        }
    }

    public function getInvoiceCount($insertConfig)
    {
        $arrSplit = explode('::', $insertConfig);

        if ($arrSplit[0] == 'countInvoices') {
            if (isset($arrSplit[1])) {
                $objInvoice = $this->Database->prepare("SELECT COUNT(id) AS count FROM tl_li_invoice WHERE isOut = '1'")->limit(1)->execute();
                $count = $objInvoice->count;
                if (!empty($GLOBALS['TL_CONFIG']['li_crm_invoice_number_generation_start'])) {
                    $count += $GLOBALS['TL_CONFIG']['li_crm_invoice_number_generation_start'];
                }
                return str_pad($count, $arrSplit[1], '0', STR_PAD_LEFT);
            }
            return false;
        }
        return false;
    }

    public function getAddressOptions(DataContainer $dc)
    {
        //echo "<pre>";
        //print_r($dc);
        //echo "</pre>";
        $addresses = array();
        $objAddresses = $this->Database->prepare("SELECT id, firstname, lastname FROM tl_address WHERE isBillingAddress = '1' AND pid = ?")->execute($dc->activeRecord->toCustomer);
        while ($objAddresses->next())
        {
            $addresses[$objAddresses->id] = $objAddresses->firstname . " " . $objAddresses->lastname;
        }
        return $addresses;
    }

    public function positionsField(DataContainer $dc, $label)
    {
        $objInvoice = $this->Database->prepare("SELECT toCustomer, positions FROM tl_li_invoice WHERE id = ?")->limit(1)->execute($dc->id);
        $positions = array();

        $unit_options = array(
            'unit' => $GLOBALS['TL_LANG']['tl_li_invoice']['units']['unit'],
            'hour' => $GLOBALS['TL_LANG']['tl_li_invoice']['units']['hour'],
            'month' => $GLOBALS['TL_LANG']['tl_li_invoice']['units']['month'],
            'year' => $GLOBALS['TL_LANG']['tl_li_invoice']['units']['year']
        );

        if ($objInvoice->positions == '') {
            $objPerformances = $this->Database->prepare("SELECT s.title, s.taxRate, s.price
                                                         FROM tl_li_service AS s
                                                         INNER JOIN tl_li_project AS p ON s.toProject = p.id
                                                         WHERE p.toCustomer = ?")
                    ->execute($objInvoice->toCustomer);
            $positions = array();
            while ($objPerformances->next())
            {
                $position = array();
                $position['quantity'] = 1;
                $position['label'] = $objPerformances->title;
                $position['tax'] = $objPerformances->taxRate;
                $position['price'] = $objPerformances->price;
                $positions[] = $position;
            }
            $objProducts = $this->Database->prepare("SELECT p.title, p.taxRate, p.price
                                                     FROM tl_li_product AS p
                                                     INNER JOIN tl_li_product_to_project AS pp ON p.id = pp.toProduct
                                                     INNER JOIN tl_li_project AS pr ON pr.id = pp.toProject
                                                     WHERE pr.toCustomer = ?")
                    ->execute($objInvoice->toCustomer);
            while ($objProducts->next())
            {
                $position = array();
                $position['quantity'] = 1;
                $position['label'] = $objProducts->title;
                $position['tax'] = $objProducts->taxRate;
                $position['price'] = $objProducts->price;
                $positions[] = $position;
            }
            $objHours = $this->Database->prepare("SELECT wp.title, (SUM(wh.hours) *60 + SUM(wh.minutes)) AS minutes, hw.wage AS price, hw.taxRate AS taxRate
                                                  FROM tl_li_work_package AS wp
                                                  INNER JOIN tl_li_working_hour AS wh ON wh.toWorkPackage = wp.id
                                                  INNER JOIN tl_li_project AS p ON wp.toProject = p.id
                                                  INNER JOIN tl_li_hourly_wage AS hw ON hw.id = wp.toHourlyWage
                                                  WHERE p.toCustomer = ?
                                                  GROUP BY wp.id")
                    ->execute($objInvoice->toCustomer);
            while ($objHours->next())
            {
                $position = array();
                $position['quantity'] = $objHours->minutes / 60;
                $position['unit'] = 'hour';
                $position['label'] = $objHours->title;
                $position['tax'] = $objHours->taxRate;
                $position['price'] = $objHours->price;
                $positions[] = $position;
            }
        }
        else
        {
            $positions = unserialize($objInvoice->positions);
        }
        $field = '<div class="clr li_positions"><h3><label>Positionen</label></h3>';
        $field .= '<div class="header">';
        $field .= '<span class="quantity">' . $GLOBALS['TL_LANG']['tl_li_invoice']['position_quantity'] . '</span>';
        $field .= '<span class="unit">' . $GLOBALS['TL_LANG']['tl_li_invoice']['position_unit'] . '</span>';
        $field .= '<span class="label">' . $GLOBALS['TL_LANG']['tl_li_invoice']['position_label'] . '</span>';
        $field .= '<span class="tax">' . $GLOBALS['TL_LANG']['tl_li_invoice']['position_tax'] . '</span>';
        $field .= '<span class="unit_price">' . $GLOBALS['TL_LANG']['tl_li_invoice']['position_unit_price'] . '</span>';
        $field .= '</div>';
        $field .= '<div class="positions">';
        $counter = count($positions);
        for ($i = 0; $i < $counter; $i++)
        {
            $field .= '<div class="position">';
            $position = $positions[$i];
            $checked = $position['print'] ? " checked" : "";

            $unit_field = '<select name="position_unit_' . $i . '" class="tl_select unit">';
            foreach ($unit_options as $key => $value)
            {
                $unit_field .= '<option value="' . $key . '"' . ($position['unit'] == $key ? ' selected'
                        : '') . '>' . $value . '</option>';
            }
            $unit_field .= '</select>';

            $field .= '<input type="text" name="position_quantity_' . $i . '" class="tl_text quantity" value="' . $position['quantity'] . '" />';
            $field .= $unit_field;
            $field .= '<input name="position_label_' . $i . '" class="tl_text label" value="' . $position['label'] . '" type="text" />';
            $field .= '<input name="position_tax_' . $i . '" class="tl_text tax" value="' . $position['tax'] . '" type="text" />';
            $field .= '<input class="tl_text price" value="' . $position['price'] . '" type="text" name="position_price_' . $i . '" />';
            $field .= '<input type="checkbox" class="checkbox print" name="position_print_' . $i . '"' . $checked . ' />';
            $field .= '<label class="print" for="position_print_' . $i . '"><img src="system/modules/li_crm/icons/invoice_generation.png" /></label>';
            $field .= '</div>';
        }
        $field .= '<input type="hidden" name="positions_count" value="' . count($positions) . '" />';
        $field .= '</div>';
        $field .= '<p class="tl_help tl_tip">Bitte wählen Sie das Rechnungstemplate aus.</p></div>';
        return $field;
    }

    public function savePositionsField(DataContainer $dc)
    {
        $counter = $this->Input->post('positions_count');

        $positions = array();
        for ($i = 0; $i < $counter; $i++)
        {
            $position = array();
            $position['quantity'] = $this->Input->post('position_quantity_' . $i);
            $position['unit'] = $this->Input->post('position_unit_' . $i);
            $position['label'] = $this->Input->post('position_label_' . $i);
            $position['price'] = $this->Input->post('position_price_' . $i);
            $position['tax'] = $this->Input->post('position_tax_' . $i);
            $position['print'] = $this->Input->post('position_print_' . $i);
            $positions[] = $position;
        }
        if (!empty($positions)) {
            $this->Database->prepare("UPDATE tl_li_invoice
                                     SET positions=?
                                     WHERE id=?")
                    ->execute(serialize($positions), $dc->id);
        }

    }

    public function printInvoice($id)
    {
        // Log process
        $this->log('Generate new invoice', 'Generate invoice with id ' . $id, TL_FILES);

        // Get data
        $objInvoice = $this->Database->prepare("SELECT i.title, i.alias, i.invoiceDate, i.performanceDate, i.toCustomer, i.toAddress, i.positions, i.isOut, t.title AS templateTitle, t.invoice_template, t.logo, t.basePath, t.periodFolder
                                                FROM tl_li_invoice AS i
                                                INNER JOIN tl_li_invoice_template AS t ON i.toTemplate = t.id
                                                WHERE i.id = ?")
                ->limit(1)
                ->execute($id);
        $objAddress = $this->Database->prepare("SELECT company, firstname, lastname, street, postal, city, gender
                                                FROM tl_address
                                                WHERE id = ?")
                ->limit(1)
                ->execute($objInvoice->toAddress);

        // Load language file
        $this->loadLanguageFile('tl_member');
        $this->loadLanguageFile('tl_li_invoice');

        // Import required systems
        $this->import('BackendUser', 'User');
        require_once (TL_ROOT . '/system/modules/dompdf/resources/dompdf_config.inc.php');

        // Generate DOMPDF object
        $dompdf = new DOMPDF();

        $templateName = $objInvoice->invoice_template;
        $templateFile = TL_ROOT . '/templates/' . $templateName . '.tpl';
        if (!file_exists($templateFile)) {
            $templateFile = TL_ROOT . '/system/modules/li_crm/templates/' . $templateName . '.tpl';
        }

        $template = file_get_contents($templateFile);

        $invoicePositions = unserialize($objInvoice->positions);

        $rowCounter = 1;
        $fullNetto = 0;
        $fullTaxes = 0;
        $taxes = array();

        foreach ($invoicePositions as $invoicePosition)
        {
            if (!$invoicePosition['print']) {
                continue;
            }

            $position_total_price = $invoicePosition['quantity'] * $invoicePosition['price'];

            if (!array_key_exists($invoicePosition['tax'], $taxes)) {
                $taxes[$invoicePosition['tax']] = $position_total_price;
            }
            else
            {
                $taxes[$invoicePosition['tax']] += $position_total_price;
            }

            $fullNetto += $invoicePosition['quantity'] * $invoicePosition['price'];

            $htmlPositions .= '<tr class="' . $this->getOddEven($rowCounter) . '">';
            $htmlPositions .= '<td class="quantity">' . $invoicePosition['quantity'] . '</td>';
            $htmlPositions .= '<td class="unit">' . $GLOBALS['TL_LANG']['tl_li_invoice']['units'][$invoicePosition['unit']] . '</td>';
            $htmlPositions .= '<td class="label">' . $invoicePosition['label'] . '</td>';
            $htmlPositions .= '<td class="unit_price price">' . $this->getFormattedNumber($invoicePosition['price']) . ' &#0128;</td>';
            $htmlPositions .= '<td class="total_price price">' . $this->getFormattedNumber($position_total_price) . ' &#0128;</td>';
            $htmlPositions .= '</tr>';

            $rowCounter++;
        }

        $htmlPositions .= '<tr class="' . $this->getOddEven($rowCounter) . '">';
        $htmlPositions .= '<td class="spacer" colspan="5"> </td>';
        $htmlPositions .= '</tr>';
        $rowCounter++;

        $htmlPositions .= '<tr class="' . $this->getOddEven($rowCounter) . ' total">';
        $htmlPositions .= '<td class="amount netto" colspan="4">' . $GLOBALS['TL_LANG']['tl_li_invoice']['total_netto'] . '</td><td class="price">' . $this->getFormattedNumber($fullNetto) . ' &#0128;</td>';
        $htmlPositions .= '</tr>';
        $rowCounter++;

        foreach ($taxes as $tax => $price)
        {
            $taxPrice = $price * $tax / 100;
            $fullTaxes += $taxPrice;
            $htmlPositions .= '<tr class="total ' . $this->getOddEven($rowCounter) . '">';
            $htmlPositions .= '<td class="amount tax" colspan="4">' . $tax . '% ' . $GLOBALS['TL_LANG']['tl_li_invoice']['tax'] . '</td><td class="price">' . $this->getFormattedNumber($taxPrice) . ' &#0128;</td>';
            $htmlPositions .= '</tr>';
            $rowCounter++;
        }

        $htmlPositions .= '<tr class="' . $this->getOddEven($rowCounter) . ' total">';
        $htmlPositions .= '<td class="amount brutto" colspan="4">' . $GLOBALS['TL_LANG']['tl_li_invoice']['total_brutto'] . '</td><td class="price">' . $this->getFormattedNumber($fullNetto + $fullTaxes) . ' &#0128;</td>';
        $htmlPositions .= '</tr>';

        $search = array(
            'logo' => '/{{logo}}/',
            'small_address' => '/{{small_address}}/',
            'company_name' => '/{{company_name}}/',
            'company_street' => '/{{company_street}}/',
            'company_postal' => '/{{company_postal}}/',
            'company_place' => '/{{company_place}}/',
            'company_phone_label' => '/{{company_phone_label}}/',
            'company_phone' => '/{{company_phone}}/',
            'company_tax_number_label' => '/{{company_tax_number_label}}/',
            'company_tax_number' => '/{{company_tax_number}}/',
            'invoice_date_label' => '/{{invoice_date_label}}/',
            'invoice_date' => '/{{invoice_date}}/',
            'invoice_number_label' => '/{{invoice_number_label}}/',
            'invoice_number' => '/{{invoice_number}}/',
            'invoice_title' => '/{{invoice_title}}/',
            'invoice_introduction' => '/{{invoice_introduction}}/',
            'customer_name' => '/{{customer_name}}/',
            'customer_firstname' => '/{{customer_firstname}}/',
            'customer_lastname' => '/{{customer_lastname}}/',
            'customer_street' => '/{{customer_street}}/',
            'customer_postal' => '/{{customer_postal}}/',
            'customer_place' => '/{{customer_place}}/',
            'position_quantity_label' => '/{{position_quantity_label}}/',
            'position_unit_label' => '/{{position_unit_label}}/',
            'position_label_label' => '/{{position_label_label}}/',
            'position_unit_price_label' => '/{{position_unit_price_label}}/',
            'position_total_price_label' => '/{{position_total_price_label}}/',
            'positions' => '/{{positions}}/',
            'performance_date_remark' => '/{{performance_date_remark}}/',
            'transfer_remark' => '/{{transfer_remark}}/',
            'account_data_label' => '/{{account_data_label}}/',
            'account_number_label' => '/{{account_number_label}}/',
            'account_number' => '/{{account_number}}/',
            'bank_code_label' => '/{{bank_code_label}}/',
            'bank_code' => '/{{bank_code}}/',
            'bank_label' => '/{{bank_label}}/',
            'bank' => '/{{bank}}/',
            'greeting' => '/{{greeting}}/'
        );

        $replace = array(
            'logo' => '<img src="' . $objInvoice->logo . '" title="Logo" alt="Logo">',
            'small_address' => $GLOBALS['TL_CONFIG']['li_crm_company_name'] . '<br />' . $GLOBALS['TL_CONFIG']['li_crm_company_street'] . ', ' . $GLOBALS['TL_CONFIG']['li_crm_company_postal'] . ' ' . $GLOBALS['TL_CONFIG']['li_crm_company_city'],
            'company_name' => $GLOBALS['TL_CONFIG']['li_crm_company_name'],
            'company_street' => $GLOBALS['TL_CONFIG']['li_crm_company_street'],
            'company_postal' => $GLOBALS['TL_CONFIG']['li_crm_company_postal'],
            'company_place' => $GLOBALS['TL_CONFIG']['li_crm_company_city'],
            'company_phone_label' => $GLOBALS['TL_LANG']['tl_member']['phone'][0],
            'company_phone' => $GLOBALS['TL_CONFIG']['li_crm_company_phone'],
            'company_tax_number_label' => $GLOBALS['TL_LANG']['tl_li_invoice']['tax_number'],
            'company_tax_number' => $GLOBALS['TL_CONFIG']['li_crm_company_tax_number'],
            'invoice_date_label' => $GLOBALS['TL_LANG']['tl_li_invoice']['date'],
            'invoice_date' => date($GLOBALS['TL_CONFIG']['dateFormat'], $objInvoice->invoiceDate),
            'invoice_number_label' => $GLOBALS['TL_LANG']['tl_li_invoice']['invoice_number'],
            'invoice_number' => $this->replaceInsertTags($GLOBALS['TL_CONFIG']['li_crm_invoice_number_generation']),
            'invoice_title' => $GLOBALS['TL_LANG']['tl_li_invoice']['invoice_legend'],
            'invoice_introduction' => sprintf($objAddress->gender == 'male'
                                                      ? $GLOBALS['TL_LANG']['tl_li_invoice']['introduction_male']
                                                      : $GLOBALS['TL_LANG']['tl_li_invoice']['introduction_female'], $objAddress->lastname),
            'customer_name' => $objAddress->company,
            'customer_firstname' => $objAddress->firstname,
            'customer_lastname' => $objAddress->lastname,
            'customer_street' => $objAddress->street,
            'customer_postal' => $objAddress->postal,
            'customer_place' => $objAddress->city,
            'position_quantity_label' => $GLOBALS['TL_LANG']['tl_li_invoice']['position_quantity'],
            'position_unit_label' => $GLOBALS['TL_LANG']['tl_li_invoice']['position_unit'],
            'position_label_label' => $GLOBALS['TL_LANG']['tl_li_invoice']['position_label'],
            'position_unit_price_label' => $GLOBALS['TL_LANG']['tl_li_invoice']['position_unit_price'],
            'position_total_price_label' => $GLOBALS['TL_LANG']['tl_li_invoice']['position_total_price'],
            'positions' => $htmlPositions,
            'performance_date_remark' => $objInvoice->invoiceDate == $objInvoice->performanceDate
                    ? $GLOBALS['TL_LANG']['tl_li_invoice']['performance_is_invoice_date']
                    : sprintf($GLOBALS['TL_LANG']['tl_li_invoice']['performance_date_at'], date($GLOBALS['TL_CONFIG']['dateFormat'], $objInvoice->performanceDate)),
            'transfer_remark' => $GLOBALS['TL_LANG']['tl_li_invoice']['transfer_remark'],
            'account_data_label' => $GLOBALS['TL_LANG']['tl_li_invoice']['account_data'],
            'account_number_label' => $GLOBALS['TL_LANG']['tl_li_invoice']['account_number'],
            'account_number' => $GLOBALS['TL_CONFIG']['li_crm_account_number'],
            'bank_code_label' => $GLOBALS['TL_LANG']['tl_li_invoice']['bank_code'],
            'bank_code' => $GLOBALS['TL_CONFIG']['li_crm_bank_code'],
            'bank_label' => $GLOBALS['TL_LANG']['tl_li_invoice']['bank'],
            'bank' => $GLOBALS['TL_CONFIG']['li_crm_bank'],
            'greeting' => sprintf($GLOBALS['TL_LANG']['tl_li_invoice']['greeting'], $GLOBALS['TL_CONFIG']['li_crm_company_name'])
        );

        $template = preg_replace($search, $replace, $template);

        $html = utf8_decode($template);

        $dompdf->set_paper('a4');
        $dompdf->set_base_path(TL_ROOT);
        $dompdf->load_html($html);
        $dompdf->render();

        // Generate export path
        $exportPath = $objInvoice->basePath == '' ? '../' . TL_ROOT . '/' : '../' . $objInvoice->basePath . '/';

        if ($objInvoice->periodFolder != '') {
            if ($objInvoice->periodFolder == 'daily') {
                $exportPath .= date('Y-z', $objInvoice->invoiceDate) . '/';
            }
            elseif ($objInvoice->periodFolder == 'weekly')
            {
                $exportPath .= date('Y-W', $objInvoice->invoiceDate) . '/';
            }
            elseif ($objInvoice->periodFolder == 'monthly')
            {
                $exportPath .= date('Y-m', $objInvoice->invoiceDate) . '/';
            }
            elseif ($objInvoice->periodFolder == 'yearly')
            {
                $exportPath .= date('Y', $objInvoice->invoiceDate) . '/';
            }
        }

        if (!file_exists($exportPath)) {
            mkdir($exportPath, 0777, true);
        }

        $exportFile = $exportPath . $objInvoice->alias . '.pdf';

        // Export pdf
        $pdfInvoice = fopen($exportFile, 'w');
        fwrite($pdfInvoice, $dompdf->output());
        fclose($pdfInvoice);

        $templateLink = substr($exportFile, 2);
        $filePath = substr($exportFile, 3);

        $this->Database->prepare("UPDATE tl_li_invoice
                                  SET file = ?
                                  WHERE id = ?")
                       ->execute($filePath, $id);

        // Return link to template
        return $templateLink;
    }

    private function sendInvoice($id)
	{
        $objInvoice = $this->Database->prepare("SELECT i.invoiceDate, i.file, a.lastname, a.gender, a.email
                                                FROM tl_li_invoice AS i
                                                INNER JOIN tl_address AS a ON a.id = i.toAddress
                                                WHERE i.id = ?")
                                     ->limit(1)
                                     ->execute($id);
		try
		{
			$objEmail = new Email();
			$objEmail->from = $GLOBALS['TL_CONFIG']['li_crm_invoice_dispatch_from'];
			$objEmail->fromName = $GLOBALS['TL_CONFIG']['li_crm_invoice_dispatch_fromName'];
			$objEmail->subject = $GLOBALS['TL_LANG']['tl_li_invoice']['dispatch_subject'];
			$objEmail->text = sprintf($objInvoice->gender == 'male'
                                              ? $GLOBALS['TL_LANG']['tl_li_invoice']['dispatch_text_male']
                                              : $GLOBALS['TL_LANG']['tl_li_invoice']['dispatch_text_female']
                , $objInvoice->lastname
                , date($GLOBALS['TL_CONFIG']['dateFormat'], $objInvoice->invoiceDate)
                , $GLOBALS['TL_CONFIG']['li_crm_company_name']);
			$objEmail->html = sprintf($objInvoice->gender == 'male'
                                              ? $GLOBALS['TL_LANG']['tl_li_invoice']['dispatch_html_male']
                                              : $GLOBALS['TL_LANG']['tl_li_invoice']['dispatch_html_female']
                , $objInvoice->lastname
                , date($GLOBALS['TL_CONFIG']['dateFormat'], $objInvoice->invoiceDate)
                , $GLOBALS['TL_CONFIG']['li_crm_company_name']);

            $objEmail->attachFile('../'.$objInvoice->file);
			$worked = $objEmail->sendTo($objInvoice->email);
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

}

?>