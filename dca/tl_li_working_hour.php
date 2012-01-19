<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     apoy2k
 * @license    MIT (see /LICENSE.txt for further information)
 */
$GLOBALS['TL_DCA']['tl_li_working_hour'] = array
(
	'config' => array
	(
		'dataContainer'		=> 'Table',
		'enableVersioning'	=> true,
		'onsubmit_callback'           => array
		(
			array('WorkingHourCalendar', 'onSubmit')
		)
	),
	'palettes' => array
	(
		'__selector__'	=> array('isExternal'),
		'default'		=> '{hour_legend}, entryDate, toWorkPackage, hours, minutes;'
	),
	'fields' => array
	(
		'user' => array(
			'default' => $this->User->id
		),
		'entryDate' => array
		(
			'label'		=> &$GLOBALS['TL_LANG']['tl_li_working_hour']['entryDate'],
			'default'	=> time(),
			'filter'	=> true,
			'sorting'	=> true,
			'flag'		=> 8,
			'inputType'	=> 'text',
			'exclude'   => true,
			'eval'		=> array('rgxp' => 'date', 'mandatory' => true,
			'datepicker' => $this->getDatePickerString(), 'tl_class' => 'w50 wizard')
		),
        'toWorkPackage' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_li_working_hour']['toWorkPackage'],
			'inputType'			=> 'select',
			'exclude'   		=> true,
			'options_callback'	=> array('WorkPackage', 'getWorkPackages'),
			'eval'				=> array('mandatory' => true, 'includeBlankOption' => true, 'tl_class' => 'w50')
		),
        'hours' => array
		(
			'label'		=> &$GLOBALS['TL_LANG']['tl_li_working_hour']['hours'],
			'inputType'	=> 'text',
			'exclude'   => true,
			'eval'		=> array('mandatory' => true, 'rgxp' => 'digit', 'tl_class' => 'w50')
		),
		'minutes' => array
		(
			'label'		=> &$GLOBALS['TL_LANG']['tl_li_working_hour']['minutes'],
			'inputType' => 'text',
			'exclude'   => true,
			'eval'		=> array('rgxp' => 'digit', 'maxlength' => '2', 'tl_class' => 'w50')
		)
	)
);
