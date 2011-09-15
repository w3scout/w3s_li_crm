<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright	Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author		ApoY2k <apoy2k@gmail.com>
 * @license		MIT (see /LICENSE.txt for further information)
 */
$GLOBALS['TL_DCA']['tl_li_timekeeping_hourly_wage'] = array
(
	'config' => array
	(
		'dataContainer'	=> 'Table',
		'enableVersioning'	=> true
	),
	'palettes' => array
	(
		'__selector__'	=> array(),
		'default'		=> '{wage}, tl_li_timekeeping_hourly_wage;'
	),
	'subpalettes' => array
	(
		'' => ''
	),
	'fields' => array
	(
		'title' => array
		(
			'label'		=> &$GLOBALS['TL_LANG']['tl_li_timekeeping_hourly_wage']['title'],
			'inputType'	=> 'text',
			'default'	=> '',
			'eval'		=> array('mandatory' => true, 'tl_class' => 'w50'),
		),
		'wage' => array
		(
			'label'		=> &$GLOBALS['TL_LANG']['tl_li_timekeeping_hourly_wage']['wage'],
			'inputType'	=> 'text',
			'default'	=> '',
            'rgxp'      => 'digit',
			'eval'		=> array('mandatory' => true, 'tl_class' => 'w50'),
		)
	)
);
