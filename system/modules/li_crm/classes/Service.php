<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @license     MIT (see /LICENSE.txt for further information)
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
