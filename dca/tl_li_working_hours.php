<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     apoy2k
 * @license    MIT (see /LICENSE.txt for further information)
 */
$GLOBALS['TL_DCA']['tl_li_working_hours'] = array
(
	'config' => array
	(
		'dataContainer'		=> 'Table',
		'enableVersioning'	=> true
	),
	'palettes' => array
	(
		'__selector__'	=> array('isExternal'),
		'default'		=> '{legend}, entryDate, toWorkPackage, hours, minutes;'
	),
	'fields' => array
	(
		'entryDate' => array
		(
			'label'		=> &$GLOBALS['TL_LANG']['tl_li_working_hours']['entryDate'],
			'default'	=> time(),
			'filter'	=> true,
			'sorting'	=> true,
			'flag'		=> 8,
			'inputType'	=> 'text',
			'eval'		=> array('rgxp' => 'date', 'mandatory' => true,
				'datepicker' => $this->getDatePickerString(), 'tl_class' => 'w50 wizard')
		),
        'toWorkPackage' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_li_working_hours']['toWorkPackage'],
			'inputType'			=> 'select',
			'options_callback'	=> array('WorkPackage', 'getWorkPackages'),
			'eval'				=> array('mandatory' => true, 'includeBlankOption' => true, 'tl_class' => 'w50')
		),
        'hours' => array
		(
			'label'		=> &$GLOBALS['TL_LANG']['tl_li_working_hours']['hours'],
			'inputType'	=> 'text',
			'eval'		=> array('mandatory' => true, 'tl_class' => 'w50')
		),
		'minutes' => array
		(
			'label'		=> &$GLOBALS['TL_LANG']['tl_li_working_hours']['minutes'],
			'inputType' => 'select',
			'options'	=> array('15', '30', '45'),
			'eval'		=> array('tl_class' => 'w50', 'includeBlankOption' => true)
		)
	)
);
