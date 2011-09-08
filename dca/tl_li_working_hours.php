<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * PHP version 5
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     apoy2k
 * @license    MIT (see /LICENSE.txt for further information)
 */

/**
 * Table tl_li_project 
 */
$GLOBALS['TL_DCA']['tl_li_working_hours'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => true
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array('isExternal'),
		'default'                     => '{legend}, tstamp, toWorkPackage, hours;'
	),
	
	// Fields
	'fields' => array
	(
		'tstamp' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_working_hours']['date'],
			'default'                 => time(),
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 8,
			'inputType'               => 'text',
			'eval'                    => array('rgxp' => 'date', 'mandatory' => true,
				'datepicker' => $this->getDatePickerString(), 'tl_class' => 'w50 wizard')
		),
        'hours' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_working_hours']['hours'],
			'inputType'               => 'text',
			'eval'                    => array('mandatory' => true, 'tl_class' => 'w50')
		),
		'toWorkPackage' => array
		(
			'label'	=> &$GLOBALS['TL_LANG']['tl_li_working_hours']['toWorkPackage'],
			'inputType' => 'select',
			'options_callback' => array('WorkPackage', 'getWorkPackages'),
			'eval' => array('mandatory' => true, 'includeBlankOption' => true, 'tl_class' => 'w50')
		)
	)
);

?>