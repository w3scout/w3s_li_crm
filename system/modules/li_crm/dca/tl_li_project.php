<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */

/**
 * Table tl_li_project 
 */
$GLOBALS['TL_DCA']['tl_li_project'] = array
(
	// Config
	'config' => array
	(
	    'dataContainer'             => 'Table',
		'enableVersioning'          => true,
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
			'fields'                => array('title'),
			'flag'                  => 1
		),
		'label' => array
		(
			'fields'                => array('title'),
			'format'                => '%s'
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
				'label'             => &$GLOBALS['TL_LANG']['tl_li_project']['edit'],
				'href'              => 'act=edit',
				'icon'              => 'edit.gif'
			),
			'copy' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_project']['copy'],
				'href'              => 'act=copy',
				'icon'              => 'copy.gif'
			),
			'delete' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_project']['delete'],
				'href'              => 'act=delete',
				'icon'              => 'delete.gif',
				'attributes'        => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_project']['show'],
				'href'              => 'act=show',
				'icon'              => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'              => array(''),
		'default'                   => '{project_legend}, toCustomer, projectNumber, title'
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
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_project']['toCustomer'],
			'inputType'             => 'select',
			'exclude'   			=> true,
			'options_callback'      => array('LiCRM\Customer', 'getCustomerOptions'),
			'eval'                  => array('mandatory'=>true, 'chosen'=>true),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
        'projectNumber' => array
		(
            'label'                 => &$GLOBALS['TL_LANG']['tl_li_project']['projectNumber'],
        	'search'                => true,
        	'sorting'               => true,
        	'flag'                  => 1,
        	'inputType'             => 'text',
        	'exclude'   			=> true,
        	'load_callback'         => array
            (
                array('LiCRM\Project', 'createNewProjectNumber')
            ),
        	'eval'                  => array('maxlength'=>255, 'alwaysSave'=>true, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'title' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_project']['title'],
			'inputType'             => 'text',
			'exclude'   			=> true,
			'eval'                  => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
		)
	)
);
