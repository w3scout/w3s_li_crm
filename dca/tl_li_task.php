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
		'enableVersioning'            => true
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
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_task']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset(); return AjaxRequest.toggleVisibility(this, %s);"',
				'button_callback'     => array('Task', 'toggleIcon')
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
			),
			'done' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_task']['done'],
				'icon'                => 'system/modules/li_crm/icons/task_done_disabled.png',
				'attributes'          => 'onclick="Backend.getScrollOffset();"',
				'button_callback'     => array('Task', 'taskDoneIcon')
			)
		)
	),
	'palettes' => array
	(
		'__selector__'                => array(''),
		'default'                     => '{settings_legend}, toCustomer, toProject, toStatus, toUser, priority;{task_legend}, title, alias, deadline, description;{publish_legend},published;'
	),
	'fields' => array
	(
        'toCustomer' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_task']['toCustomer'],
			'inputType'               => 'select',
			'exclude'   			  => true,
			'options_callback'        => array('Customer', 'getCustomerOptions'),
			'eval'                    => array('tl_class' => 'w50','includeBlankOption' => true, 'submitOnChange' => true)
		),
        'toProject' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_task']['toProject'],
			'inputType'               => 'select',
			'exclude'   			  => true,
			'eval'                    => array('tl_class' => 'w50', 'includeBlankOption' => true),
			'options_callback'        => array('Project', 'getProjectsOfCustomer')
		),
        'toStatus' => array
		(
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_task']['toStatus'],
			'filter'                  => true,
			'inputType'               => 'select',
			'exclude'   			  => true,
            'foreignKey'              => 'tl_li_task_status.title',
			'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50', 'mandatory'=>true)
        ),
        'toUser' => array
		(
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_task']['toUser'],
			'filter'                  => true,
			'inputType'               => 'select',
			'exclude'   			  => true,
            'foreignKey'              => 'tl_user.username',
			'eval'                    => array('tl_class'=>'w50')
        ),
        'priority' => array
		(
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_task']['priority'],
			'filter'                  => true,
			'inputType'               => 'select',
			'exclude'   			  => true,
			'options_callback'        => array('Task', 'getPriorityOptions'),
			'eval'                    => array('tl_class'=>'w50')
        ),
        'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_task']['title'],
			'inputType'               => 'text',
			'exclude'   			  => true,
			'search'                  => true,
			'eval'                    => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50')
		),
		'alias' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_task']['alias'],
			'inputType'               => 'text',
			'exclude'   			  => true,
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
			'exclude'   			  => true,
			'eval'                    => array('rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard')
		),
		'description' => array
		(
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_task']['description'],
			'search'                  => true,
			'inputType'               => 'textarea',
			'exclude'   			  => true,
			'eval'                    => array('tl_class'=>'clr', 'rte'=>'tinyMCE')
        ),
		'published' => array
		(
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_task']['published'],
			'inputType'               => 'checkbox',
			'exclude'   			  => true,
			'filter'                  => true
        )
	)
);