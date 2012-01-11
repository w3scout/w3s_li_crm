<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @license     MIT (see /LICENSE.txt for further information)
 */

/**
 * Class ModuleInvoiceList
 */
class ModuleInvoiceList extends Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_invoicelist';

	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### INVOICE LIST ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		return parent::generate();
	}


	/**
	 * Generate module
	 */
	protected function compile()
	{
		$this->loadLanguageFile('tl_li_invoice');
		$this->import('FrontendUser', 'User');
		
		$objPage = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE id=?")
								  ->limit(1)
								  ->execute($this->jumpTo);
		$jumpToAssoc = $objPage->fetchAssoc();
		if($GLOBALS['TL_CONFIG']['arrUrlFragments'] != null &&
			is_array($GLOBALS['TL_CONFIG']['arrUrlFragments']) &&
			array_key_exists($objPage->alias, $GLOBALS['TL_CONFIG']['arrUrlFragments'])) {
			$folder = '/%s';
		} else {
			$folder = '/items/%s';
		}
		$jumpTo = $this->generateFrontendUrl($jumpToAssoc, $folder);
		
		if($this->User->id != 0) {
			$objInvoices = $this->Database->prepare('SELECT i.id, i.title, i.invoiceDate, i.alias, i.price, i.currency, i.file, c.cssClass
												  	 FROM tl_li_invoice AS i
												  	 LEFT JOIN tl_li_invoice_category AS c ON c.id = i.toCategory
												  	 WHERE i.toCustomer = ? AND i.published = 1
												  	 ORDER BY invoiceDate DESC')->execute($this->User->id);
		} else {
			$objInvoices = $this->Database->execute('SELECT i.id, i.title, i.invoiceDate, i.alias, i.price, i.currency, i.file, c.cssClass
												  	 FROM tl_li_invoice AS i
												  	 LEFT JOIN tl_li_invoice_category AS c ON c.id = i.toCategory
												  	 WHERE i.published = 1
												  	 ORDER BY invoiceDate DESC');
		}
		
		$jumpToFile = $this->generateFrontendUrl($jumpToAssoc);
		
		$arrInvoices = array();
		$currencyHelper = new CurrencyHelper();
		while($objInvoices->next() != null) {
			$curJumpTo = sprintf($jumpTo, $objInvoices->alias);
			$newArray = array(
				'id' => $objInvoices->id,
				'title' => $objInvoices->title,
				'date' => $objInvoices->invoiceDate,
				'price' => $this->getFormattedNumber($objInvoices->price).' '.$currencyHelper->getSymbolOfCode($objInvoices->currency),
				'currency' => strtolower($objInvoices->currency),
				'fileAvailable' => $objInvoices->file != '',
				'jumpTo' => $curJumpTo,
				'file' => $jumpToFile.'?key=pdf&id='.$objInvoices->id,
				'cssClass' => $objInvoices->cssClass
			);
			$arrInvoices[] = $newArray;
		}
		
		$this->Template->user = $this->User;
		$this->Template->invoices = $arrInvoices;
	}
}

?>