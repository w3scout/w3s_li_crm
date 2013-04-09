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
 * Class CompanySettings
 */
class CompanySettings extends \Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
	}

	public function getTaxOptions()
	{
        $taxes = $this->Database->prepare("
        	SELECT id, title, rate
            FROM tl_li_tax
        ")->execute();
		$taxOptions = array();
        while($taxes->next())
        {
            $taxOptions[$taxes->id] = $taxes->title." - ".$taxes->rate."%";
        }
		return $taxOptions;
	}
}
