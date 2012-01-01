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
        $taxes = $this->Database->prepare("SELECT id, title, rate
            FROM tl_li_tax")->execute();
		$taxOptions = array();
        while($taxes->next())
        {
            $taxOptions[$taxes->id] = $taxes->title." - ".$taxes->rate."%";
        }
		return $taxOptions;
	}

}
