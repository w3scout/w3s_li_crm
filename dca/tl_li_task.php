<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */
$GLOBALS['TL_DCA']['tl_li_task'] = array
(
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => true,
	),
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('toStatus', 'priority'),
			'flag'                    => 1,
			'panelLayout'             => 'filter;sort,search,limit'
		),
		'label' => array
		(
			'fields'                  => array('title'),
			'label_callback'          => array('Task', 'renderLabel')
		),
		'global_operations' => array
		(
            'reminder' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_task']['reminder'],
				'href'                => 'table=tl_li_task_reminder',
				'class'               => 'header_task_reminder',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			),
            'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_task']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_task']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_task']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_task']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			),
			'new_reminder' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_task_reminder']['new'],
				'href'                => 'table=tl_li_task_reminder&act=create',
				'icon'                => 'system/modules/li_crm/icons/reminder_add.png'
			)
		)
	),
	'palettes' => array
	(
		'__selector__'                => array(''),
		'default'                     => '{settings_legend}, toProject, toStatus, toUser, priority;{task_legend}, title, alias, deadline, description;'
	),
	'fields' => array
	(
        'toProject' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_task']['toProject'],
			'inputType'               => 'select',
			'options_callback'        => array('Project', 'getProjectsByCustomerList'),
			'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50')
		),
        'toStatus' => array
		(
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_task']['toStatus'],
			'filter'                  => true,
			'inputType'               => 'select',
            'foreignKey'              => 'tl_li_task_status.title',
			'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50', 'mandatory'=>true)
        ),
        'toUser' => array
		(
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_task']['toUser'],
			'filter'                  => true,
			'inputType'               => 'select',
            'foreignKey'              => 'tl_user.username',
			'eval'                    => array('tl_class'=>'w50')
        ),
        'priority' => array
		(
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_task']['priority'],
			'filter'                  => true,
			'inputType'               => 'select',
			'options_callback'        => array('Task', 'getPriorityOptions'),
			'eval'                    => array('tl_class'=>'w50')
        ),
        'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_task']['title'],
			'inputType'               => 'text',
			'search'                  => true,
			'eval'                    => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50')
		),
		'alias' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_task']['alias'],
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'alnum', 'unique'=>true, 'spaceToUnderscore'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('Task', 'generateAlias')
			)
		),
		'deadline' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_task']['deadline'],
			'default'                 => time(),
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 8,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'mandatory'=>true, 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard')
		),
		'description' => array
		(
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_task']['description'],
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('tl_class'=>'clr', 'rte'=>'tinyMCE')
        )
	)
);
