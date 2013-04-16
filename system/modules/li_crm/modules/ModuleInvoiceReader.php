<?php

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @license     MIT (see /LICENSE.txt for further information)
 */

namespace W3S\LiCRM;

/**
 * Class ModuleInvoiceReader
 */
class ModuleInvoiceReader extends \Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_invoicereader';

	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### INVOICE READER ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id='.$this->id;

			return $objTemplate->parse();
		}

		return parent::generate();
	}

	/**
	 * Generate module
	 */
	protected function compile()
	{
		global $objPage;
		$key = \Input::get('key');
		$id = \Input::get('id');

		if ($key == '')
		{
			$this->loadLanguageFile('tl_li_invoice');
			$this->import('FrontendUser', 'User');
			$alias = \Input::get('items');

			if($this->User->id != '')
			{
				$objInvoice = $this->Database->prepare("
					SELECT i.id, i.title, i.invoiceDate, i.alias, i.price, i.currency, i.file, c.cssClass
					FROM tl_li_invoice AS i
					LEFT JOIN tl_li_invoice_category AS c
						ON c.id = i.toCategory
					WHERE i.alias = ?
						AND i.toCustomer = ?
						AND i.published = 1
				")->execute($alias, $this->User->id);
			}
			else
			{
				$objInvoice = $this->Database->prepare("
					SELECT i.id, i.title, i.invoiceDate, i.alias, i.price, i.currency, i.file, c.cssClass
					FROM tl_li_invoice AS i
					LEFT JOIN tl_li_invoice_category AS c
						ON c.id = i.toCategory
					WHERE i.alias = ?
						AND i.published = 1
				")->execute($alias);
			}
			
			if ($objInvoice->numRows == 1)
			{
				$currencyHelper = new CurrencyHelper();
				$arrInvoice = array(
						'id'            => $objInvoice->id,
						'title'         => $objInvoice->title,
						'date'          => $objInvoice->invoiceDate,
						'price'         => $this->getFormattedNumber($objInvoice->price).' '.$currencyHelper->getSymbolOfCode($objInvoice->currency),
						'currency'      => strtolower($objInvoice->currency),
						'fileAvailable' => $objInvoice->file != '',
						'file'          => $this->generateFrontendUrl($objPage->row(), '/items/'. $objInvoice->alias).'?key=pdf&id='.$objInvoice->id,
						'cssClass'      => $objInvoice->cssClass
				);
				$this->Template->invoice = $arrInvoice;
				$this->Template->invoiceFound = true;
			}
		}
		elseif($key == 'pdf')
		{
			$invoice = new Invoice();
			$invoice->returnFileForFrontend($id);
		}

	}
}
