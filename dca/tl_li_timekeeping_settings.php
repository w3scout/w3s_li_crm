<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * @copyright	Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author		apoy2k
 * @license		MIT (see /LICENSE.txt for further information)
 */
$GLOBALS['TL_DCA']['tl_li_timekeeping_settings'] = array
(
	'config' => array
	(
		'dataContainer'	=> 'File',
		'closed'		=> true
	),
	'palettes' => array
	(
		'__selector__'	=> array(),
		'default'		=> '{calendar},li_crm_timekeeping_week_mode;'
	),
	'subpalettes' => array
	(
		'' => ''
	),
	'fields' => array
	(
		'li_crm_timekeeping_week_mode' => array
		(
			'label'		=> &$GLOBALS['TL_LANG']['tl_li_timekeeping_settings']['calendarWeekMode'],
			'inputType'	=> 'select',
			'default'	=> '7',
			'options'	=> &$GLOBALS['TL_LANG']['tl_li_timekeeping_settings']['calendarWeekModeOptions'],
			'eval'		=> array('mandatory' => true, 'tl_class'=>'w50', 'helpwizard' => true),
			'explanation' => 'li_crm_timekeeping_calendar_week_mode'
		)
	)
);
