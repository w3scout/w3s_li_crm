<?php

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */

/**
 * Table tl_li_appointment
 */
$GLOBALS['TL_DCA']['tl_li_appointment'] = array
(
	// Config
	'config' => array
	(
		'dataContainer'             => 'Table',
		'enableVersioning'			=> true,
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary'
            )
        )
	),
	
	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                  => 1,
			'fields'                => array('subject'),
			'flag'                  => 1,
			'panelLayout'           => 'filter;sort,search,limit'
		),
		'label' => array
		(
			'fields'                => array('subject')
		),
		'global_operations' => array
		(
            'all' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'              => 'act=select',
				'class'             => 'header_edit_all',
				'attributes'        => 'onclick="Backend.getScrollOffset();"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_appointment']['edit'],
				'href'              => 'act=edit',
				'icon'              => 'edit.gif'
			),
			'copy' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_appointment']['copy'],
				'href'              => 'act=copy',
				'icon'              => 'copy.gif'
			),
			'delete' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_appointment']['delete'],
				'href'              => 'act=delete',
				'icon'              => 'delete.gif',
				'attributes'        => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			)
		)
	),
	
	// Palettes
	'palettes' => array
	(
		'__selector__'              => array('repetition'),
		'default'                   => '{date_legend},toCustomer,creator,subject,toTask,participants,place,color,note;
										{time_legend},startDate,endDate,startTime,endTime,repetition;
										{visibility_legend},private;'
	),
	
	// Subpalettes
	'subpalettes' => array
	(
		'repetition' 				=> 'period'
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
        'toCustomer' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_appointment']['toCustomer'],
			'inputType'             => 'select',
			'exclude'   			=> true,
			'options_callback'      => array('LiCRM\Customer', 'getCustomerOptions'),
			'eval'                  => array('tl_class'=>'w50', 'chosen'=>true, 'includeBlankOption'=>true, 'submitOnChange'=>true),
            'sql'                   => "int(10) unsigned NOT NULL default '0'"
		),
        'creator' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_appointment']['creator'],
			'inputType'             => 'select',
			'foreignKey'			=> 'tl_user.name',
            'default'               => $this->User->id,
			'exclude'   			=> true,
			'eval'                  => array('mandatory'=>true, 'chosen'=>true, 'tl_class'=>'w50', 'includeBlankOption'=>false),
            'sql'                   => "int(10) unsigned NOT NULL default '0'"
		),
        'subject' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_appointment']['subject'],
			'inputType'             => 'text',
            'default'               => '-',
			'exclude'   			=> true,
			'search'                => true,
			'eval'                  => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50'),
            'sql'                   => "varchar(255) NOT NULL default ''"
		),
		'toTask' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_appointment']['task'],
			'inputType'             => 'select',
			'options_callback'		=> array('LiCRM\Task', 'getTaskOptions'),
			'exclude'   			=> true,
			'eval'                  => array('tl_class'=>'w50', 'chosen'=>true, 'includeBlankOption'=>true),
            'sql'                   => "int(10) unsigned NOT NULL default '0'"
		),
		'participants' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_appointment']['participants'],
			'exclude'               => true,
			'filter'                => true,
			'inputType'             => 'checkboxWizard',
			'foreignKey'            => 'tl_user.name',
			'eval'                  => array('tl_class'=>'clr', 'multiple'=>true),
            'sql'                   => "blob NULL"
		),
		'place' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_appointment']['place'],
			'inputType'             => 'text',
			'exclude'   			=> true,
			'search'                => true,
			'eval'                  => array('maxlength'=>250, 'tl_class'=>'w50'),
            'sql'                   => "varchar(255) NOT NULL default ''"
		),
		'color' => array
		(
			'label'     			=> &$GLOBALS['TL_LANG']['tl_li_appointment']['color'],
			'search'    			=> true,
			'sorting'   			=> true,
			'flag'      			=> 1,
			'inputType' 			=> 'text',
			'exclude'   			=> true,
			'eval'      			=> array('maxlength'=>6, 'isHexColor'=>true, 'colorpicker'=>true, 'tl_class'=>'w50 wizard'),
            'sql'                   => "varchar(6) NOT NULL default ''"
		),
		'note' => array
		(
            'label'                 => &$GLOBALS['TL_LANG']['tl_li_appointment']['note'],
			'search'                => true,
			'inputType'             => 'textarea',
			'exclude'   			=> true,
			'eval'                  => array('tl_class'=>'clr', 'rte'=>'tinyMCE'),
            'sql'                   => "text NOT NULL"
        ),
        'startDate' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_appointment']['startDate'],
			'default'               => time(),
			'exclude'               => true,
			'inputType'             => 'text',
			'eval'                  => array('rgxp'=>'date', 'mandatory'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
            'sql'                   => "int(10) unsigned NULL"
		),
		'endDate' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_appointment']['endDate'],
            'exclude'               => true,
			'inputType'             => 'text',
			'eval'                  => array('rgxp'=>'date', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
            'sql'                   => "int(10) unsigned NULL"
		),
        'startTime' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_appointment']['startTime'],
			'default'               => time(),
			'exclude'               => true,
			'filter'                => true,
			'sorting'               => true,
			'flag'                  => 8,
			'inputType'             => 'text',
			'eval'                  => array('rgxp'=>'time', 'mandatory'=>true, 'tl_class'=>'w50'),
            'sql'                   => "int(10) unsigned NULL"
		),
		'endTime' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_appointment']['endTime'],
            'default'               => time(),
			'exclude'               => true,
			'inputType'             => 'text',
			'eval'                  => array('rgxp'=>'time', 'mandatory'=>true, 'tl_class'=>'w50'),
            'sql'                   => "int(10) unsigned NULL"
		),
        'repetition' => array
		(
            'label'                 => &$GLOBALS['TL_LANG']['tl_li_appointment']['repetition'],
			'inputType'             => 'checkbox',
			'exclude'   			=> true,
			'filter'                => true,
			'eval'					=> array('tl_class'=>'clr', 'submitOnChange'=>true),
            'sql'                   => "char(1) NOT NULL default ''"
        ),
        'period' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_appointment']['period'],
			'inputType'             => 'select',
			'exclude'   			=> true,
			'options'               => array('weekly', 'biweekly', 'monthly'),
			'reference'				=> &$GLOBALS['TL_LANG']['tl_li_appointment']['periods'],
			'eval'                  => array('includeBlankOption'=>true, 'chosen'=>true),
            'sql'                   => "varchar(20) NOT NULL default ''"
		),
		'private' => array
		(
            'label'                 => &$GLOBALS['TL_LANG']['tl_li_appointment']['private'],
			'inputType'             => 'checkbox',
			'exclude'   			=> true,
			'filter'                => true,
            'sql'                   => "char(1) NOT NULL default ''"
        )
	)
);
