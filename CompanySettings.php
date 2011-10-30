<?php
if (!defined('TL_ROOT'))
	die('You cannot access this file directly!');

/**
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */
class CompanySettings extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
	}

	/**
	 * Get all tax rates as options.
	 *
	 * @return array The tax options
	 */
	public function getTaxOptions()
	{
		$taxes = unserialize($GLOBALS['TL_CONFIG']['li_crm_taxes']);
		$taxOptions = array();
		if (count($taxes))
		{
			foreach ($taxes as $tax)
			{
				$taxOptions[$tax['rate']] = $tax['label']." - ".$tax['rate']."%";
			}
		}
		return $taxOptions;
	}

}
