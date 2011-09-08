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
 * Class InvoiceCategory
 */
class InvoiceCategory extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
	}

	public function renderGroup($row)
	{
		return $GLOBALS['TL_LANG']['tl_li_invoice_category']['orderNumber'][0]." ".$row['orderNumber'];
	}

}
?>