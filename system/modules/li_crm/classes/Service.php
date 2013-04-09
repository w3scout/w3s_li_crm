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
 * Class Service
 */
class Service extends \Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
	}

    public function getUnitOptions() {
        return array
        (
            'unit' => $GLOBALS['TL_LANG']['tl_li_service']['units']['unit'],
            'hour' => $GLOBALS['TL_LANG']['tl_li_service']['units']['hour'],
            'month' => $GLOBALS['TL_LANG']['tl_li_service']['units']['month'],
            'year' => $GLOBALS['TL_LANG']['tl_li_service']['units']['year']
        );
    }
}
