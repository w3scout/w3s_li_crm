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
 * Class InvoiceTemplate
 */
class InvoiceTemplate extends \Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
	}

	public function getInvoiceTemplates(\DataContainer $dc)
	{
		return $this->getTemplateGroup('invoice_');
	}
	
	public function moveHtaccessFile($path, \DataContainer $dc) {
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

	public function updateDefaultTemplate($dc)
	{
		if (\Input::post('isDefaultTemplate'))
		{
			// Reset default template in all templates
			$this->Database->prepare("
				UPDATE tl_li_invoice_template
				SET isDefaultTemplate = 0
				WHERE NOT id = ?
			")->execute($dc->id);
		}
	}
	
	public function getDefaultTemplate() {

        if ($this->Database->tableExists('tl_li_invoice_template'))
        {
            $objTemplate = $this->Database->prepare("
                SELECT id
                FROM tl_li_invoice_template
                WHERE isDefaultTemplate = 1
            ")->limit(1)->execute();

            if($objTemplate->id != '') {
                return $objTemplate->id;
            }
        }

        return 0;
	}
}