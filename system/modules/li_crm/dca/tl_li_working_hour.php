<?php

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */

/**
 * Table tl_li_working_hour
 */
$GLOBALS['TL_DCA']['tl_li_working_hour'] = array
(
	// Config
	'config' => array
	(
		'dataContainer'             => 'Table',
		'enableVersioning'          => true,
		'onsubmit_callback'         => array
		(
			array('LiCRM\WorkingHourCalendar', 'onSubmit')
		),
		'ondelete_callback'         => array
		(
			array('LiCRM\WorkingHourCalendar', 'onDelete')
		),
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary'
            )
        )
	),
	
	// Palettes
	'palettes' => array
	(
		'__selector__'				=> array('isExternal'),
		'default'					=> '{hour_legend},entryDate,toWorkPackage,hours,minutes;'
	),
	
	// Fields
	'fields' => array
	(
        'id' => array(
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'user' => array
        (
			'default' 				=> $this->User->id,
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'entryDate' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_li_working_hour']['entryDate'],
			'default'				=> time(),
			'filter'				=> true,
			'sorting'				=> true,
			'flag'					=> 8,
			'inputType'				=> 'text',
			'exclude'   			=> true,
			'eval'					=> array('rgxp'=>'date', 'mandatory'=>true,	'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
        'toWorkPackage' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_li_working_hour']['toWorkPackage'],
			'inputType'				=> 'select',
			'exclude'   			=> true,
			'options_callback'		=> array('LiCRM\WorkPackage', 'getWorkPackages'),
			'eval'					=> array('mandatory' => true, 'chosen'=>true, 'includeBlankOption' => true, 'tl_class' => 'w50'),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
        'hours' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_li_working_hour']['hours'],
			'inputType'				=> 'text',
			'exclude'   			=> true,
			'eval'					=> array('mandatory' => true, 'rgxp' => 'digit', 'tl_class' => 'w50'),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'minutes' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_li_working_hour']['minutes'],
			'inputType' 			=> 'text',
			'exclude'   			=> true,
			'eval'					=> array('rgxp'=>'digit', 'maxlength'=>'2', 'tl_class'=>'w50'),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
		)
	)
);
