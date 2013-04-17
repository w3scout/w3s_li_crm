<?php

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @license     MIT (see /LICENSE.txt for further information)
 */

/**
 * Add palettes to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['registration'] = str_replace('reg_groups,','reg_groups,isCustomer,',$GLOBALS['TL_DCA']['tl_module']['palettes']['registration']);

/**
 * Add fields to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['isCustomer'] = array
(
	'label'         => &$GLOBALS['TL_LANG']['tl_module']['isCustomer'],
	'exclude'       => true,
	'inputType'     => 'checkbox',
	'eval'          => array(),
    'sql' => "char(1) NOT NULL default ''"
);