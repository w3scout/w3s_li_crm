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
		'dataContainer'	=> 'File'
	),
	'palettes' => array
	(
		'__selector__'	=> array(),
		'default'		=> '{calendar_legend},li_crm_timekeeping_week_mode;'
	),
	'fields' => array
	(
		'li_crm_timekeeping_week_mode' => array
		(
			'label'		  => &$GLOBALS['TL_LANG']['tl_li_timekeeping_settings']['li_crm_timekeeping_week_mode'],
			'inputType'	  => 'select',
			'exclude'     => true,
			'default'	  => '7',
			'explanation' => 'li_crm_timekeeping_calendar_week_mode',
			'options'	  => array('7', '3', '2', '6'),
			'reference'   => &$GLOBALS['TL_LANG']['tl_li_timekeeping_settings']['calendarWeekModeOptions'],
			'eval'		  => array('helpwizard' => true, 'chosen'=>true, 'mandatory' => true, 'tl_class'=>'w50 wizard')
		)
	)
);
