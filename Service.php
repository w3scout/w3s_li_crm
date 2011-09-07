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
 * Class Service
 */
class Service extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
	}

	public function getDefaultPrice($value, $dc)
	{
		$objType = $this->Database->prepare("SELECT standardPrice FROM tl_li_service_type WHERE id = ?")->limit(1)->execute($dc->activeRecord->toServiceType);
		$standardPrice = $objType->standardPrice;
		if ($standardPrice != 0)
		{
			return $standardPrice;
		}
		else
		{
			return $value;
		}
	}

}
?>