<?php

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */

/**
 * Table tl_li_work_package
 */
$GLOBALS['TL_DCA']['tl_li_work_package'] = array
(
	// Config
	'config' => array
	(
		'dataContainer'             => 'Table',
		'enableVersioning'      	=> true,
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
			'mode'              	=> 1,
			'fields'            	=> array('toCustomer'),
            'flag'              	=> 11,
            'panelLayout'       	=>'filter;search,limit'
		),
		'label' => array
		(
            'fields'            	=> array('title'),
            'group_callback'    	=> array('LiCRM\WorkPackage', 'getGroupLabel'),
            'label_callback'    	=> array('LiCRM\WorkPackage', 'getLabel')
		),
		'global_operations' => array
		(
            'all' => array
			(
				'label'         	=> &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'          	=> 'act=select',
				'class'         	=> 'header_edit_all',
				'attributes'    	=> 'onclick="Backend.getScrollOffset();"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'         	=> &$GLOBALS['TL_LANG']['tl_li_work_package']['edit'],
				'href'          	=> 'act=edit',
				'icon'          	=> 'edit.gif'
			),
			'copy' => array
			(
				'label'         	=> &$GLOBALS['TL_LANG']['tl_li_work_package']['copy'],
				'href'          	=> 'act=copy',
				'icon'          	=> 'copy.gif'
			),
			'delete' => array
			(
				'label'         	=> &$GLOBALS['TL_LANG']['tl_li_work_package']['delete'],
				'href'          	=> 'act=delete',
				'icon'          	=> 'delete.gif',
				'attributes'    	=> 'onclick="if (!confirm(\''.$GLOBALS['TL_LANG']['MSC']['deleteConfirm'].'\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'         	=> &$GLOBALS['TL_LANG']['tl_li_work_package']['show'],
				'href'          	=> 'act=show',
				'icon'          	=> 'show.gif'
			)
		)
	),
	
	// Palettes
	'palettes' => array
	(
		'__selector__'          	=> array('isExternal'),
		'default'              		=> '{package_legend},title,toHourlyWage,hourLimit;
										{settings_legend},isExternal;'
	),
	
	// Subpalettes
	'subpalettes' => array
	(
		'isExternal'            	=> 'toCustomer,toProject,printOnInvoice'
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
        'title' => array
		(
			'label'             	=> &$GLOBALS['TL_LANG']['tl_li_work_package']['title'],
			'inputType'         	=>'text',
			'exclude'           	=> true,
            'search'            	=> true,
			'eval'              	=> array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
		),
        'toHourlyWage' => array
        (
            'label'             	=> &$GLOBALS['TL_LANG']['tl_li_work_package']['toHourlyWage'],
            'inputType'         	=> 'select',
            'exclude'   			=> true,
            'filter'            	=> true,
            'foreignKey'        	=> 'tl_li_hourly_wage.title',
            'options_callback'  	=> array('LiCRM\HourlyWage', 'getHourlyWagesList'),
            'eval'              	=> array('mandatory'=>true, 'chosen'=>true, 'includeBlankOption'=>true, 'tl_class'=>'w50'),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'hourLimit' => array
        (
            'label'             	=> &$GLOBALS['TL_LANG']['tl_li_work_package']['hourLimit'],
            'inputType'         	=>'text',
            'exclude'           	=> true,
            'eval'              	=> array('rgxp'=>'digit', 'maxlength'=>4, 'tl_class'=>'w50'),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
		'isExternal' => array
        (
        	'label'             	=> &$GLOBALS['TL_LANG']['tl_li_work_package']['isExternal'],
        	'inputType'         	=>'checkbox',
        	'exclude'           	=> true,
            'filter'            	=> true,
        	'eval'              	=> array('submitOnChange'=>true, 'tl_class'=>'clr'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'toCustomer' => array
		(
			'label'             	=> &$GLOBALS['TL_LANG']['tl_li_work_package']['toCustomer'],
			'inputType'         	=> 'select',
			'exclude'   			=> true,
			'options_callback'  	=> array('LiCRM\Customer', 'getCustomerOptions'),
			'eval'              	=> array('mandatory'=>true, 'chosen'=>true, 'tl_class'=>'w50', 'includeBlankOption'=>true, 'submitOnChange'=>true),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
        'toProject' => array
		(
			'label'             	=> &$GLOBALS['TL_LANG']['tl_li_work_package']['toProject'],
			'inputType'         	=> 'select',
			'exclude'   			=> true,
			'options_callback'  	=> array('LiCRM\Project', 'getProjectsOfCustomer'),
            'eval'              	=> array('tl_class'=>'w50', 'chosen'=>true, 'includeBlankOption'=>true),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'printOnInvoice' => array
		(
			'label'             	=> &$GLOBALS['TL_LANG']['tl_li_work_package']['printOnInvoice'],
			'inputType'         	=> 'checkbox',
			'exclude'   			=> true,
            'filter'            	=> true,
			'eval'              	=> array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
		)
	)
);
