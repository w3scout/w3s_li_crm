<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */

/**
 * Table tl_li_task_status
 */
$GLOBALS['TL_DCA']['tl_li_task_status'] = array
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
			'fields'                => array('orderNumber'),
			'flag'                  => 11
		),
		'label' => array
		(
			'fields'                => array('icon', 'title', 'title'),
			'format'                => '<img src=\'%s\' alt=\'%s\' /> %s',
			'label_callback'        => array('LiCRM\TaskStatus', 'renderLabel'),
			'group_callback'        => array('LiCRM\TaskStatus', 'renderGroup'),
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
				'label'             => &$GLOBALS['TL_LANG']['tl_li_task_status']['edit'],
				'href'              => 'act=edit',
				'icon'              => 'edit.gif'
			),
			'copy' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_task_status']['copy'],
				'href'              => 'act=copy',
				'icon'              => 'copy.gif'
			),
			'delete' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_task_status']['delete'],
				'href'              => 'act=delete',
				'icon'              => 'delete.gif',
				'attributes'        => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_task_status']['show'],
				'href'              => 'act=show',
				'icon'              => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'              => array(''),
		'default'                   => '{status_legend}, title, orderNumber, icon;
										{settings_legend}, isTaskDisabled, isTaskDone, showOnStartpage, cssClass;'
	),
	
	// Fields
	'fields' => array
	(
        'id' => array(
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp' => array
        (
            'default' => time(),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'title' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_task_status']['title'],
			'inputType'             => 'text',
			'exclude'   			=> true,
			'eval'                  => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'orderNumber' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_task_status']['orderNumber'],
			'inputType'             => 'text',
			'exclude'   			=> true,
			'eval'                  => array('mandatory'=>true, 'maxlength'=>12, 'tl_class'=>'w50', 'rgxp'=>'digit'),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'icon' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_task_status']['icon'],
			'inputType'             => 'fileTree',
			'exclude'   			=> true,
			'eval'                  => array('fieldType'=>'radio', 'tl_class'=>'clr', 'files'=>true, 'filesOnly'=>true),
            'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'isTaskDisabled' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_task_status']['isTaskDisabled'],
			'inputType'             => 'checkbox',
			'exclude'   			=> true,
			'eval'                  => array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
		),
		'isTaskDone' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_task_status']['isTaskDone'],
			'inputType'             => 'checkbox',
			'exclude'   			=> true,
			'eval'                  => array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
		),
        'showOnStartpage' => array
        (
            'label'                 => &$GLOBALS['TL_LANG']['tl_li_task_status']['showOnStartpage'],
            'inputType'             => 'checkbox',
            'exclude'   			=> true,
            'eval'                  => array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
		'cssClass' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_task_status']['cssClass'],
			'inputType'             => 'text',
			'exclude'   			=> true,
			'eval'                  => array('maxlength'=>250, 'tl_class'=>'clr w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
		)
	)
);
