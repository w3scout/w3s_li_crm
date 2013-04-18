<?php

/**
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @author	   ApoY2k <apoy2k@gmail.com>
 * @license	   MIT (see /LICENSE.txt for further information)
 */

/**
 * Settings - Timekeeping settings
 */
$GLOBALS['TL_DCA']['tl_li_timekeeping_settings'] = array
(
	// Config
	'config' => array
	(
	    'dataContainer'             => 'File',
	),
	
	// Palettes
	'palettes' => array
	(
		'__selector__'				=> array(),
		'default'					=> '{calendar_legend},li_crm_timekeeping_week_mode;'
	),
	
	// Fields
	'fields' => array
	(
		'li_crm_timekeeping_week_mode' => array
		(
			'label'		  			=> &$GLOBALS['TL_LANG']['tl_li_timekeeping_settings']['li_crm_timekeeping_week_mode'],
			'inputType'	  			=> 'select',
			'exclude'     			=> true,
			'default'	  			=> '7',
			'explanation' 			=> 'li_crm_timekeeping_calendar_week_mode',
			'options'	  			=> array('7', '3', '2', '6'),
			'reference'   			=> &$GLOBALS['TL_LANG']['tl_li_timekeeping_settings']['calendarWeekModeOptions'],
			'eval'		  			=> array('helpwizard'=>true, 'chosen'=>true, 'mandatory'=>true, 'tl_class'=>'w50 wizard')
		)
	)
);
