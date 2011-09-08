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

}
?>