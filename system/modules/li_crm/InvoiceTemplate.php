<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @license     MIT (see /LICENSE.txt for further information)
 */

/**
 * Class InvoiceTemplate
 */
class InvoiceTemplate extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
	}

	public function getInvoiceTemplates(DataContainer $dc)
	{
		return $this->getTemplateGroup('invoice_');
	}
	
	public function moveHtaccessFile($path, DataContainer $dc) {
		$exportPath = '../'.$path.'/';
		$htaccess = '.htaccess';
		
		if (!file_exists($exportPath))
		{
			mkdir($exportPath, 0777, true);
		}
		
		$file = fopen($exportPath.$htaccess, 'w+');
		fwrite($file, 'deny from all');
		fclose($file);

		return $path;
	}
}
