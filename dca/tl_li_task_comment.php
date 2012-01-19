<?php
if (!defined('TL_ROOT'))
	die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @author      Tristan Lins <tristan.lins@infinitysoft.de>
 * @license     MIT (see /LICENSE.txt for further information)
 */
$this->loadLanguageFile('tl_li_task_comment_reminder');
$GLOBALS['TL_DCA']['tl_li_task_comment'] = array
(
	'config'      => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_li_task',
		'onload_callback'             => array
		(
			array('TaskComment', 'onLoad')
		),
		'onsubmit_callback'           => array
		(
			array('TaskComment', 'onSubmit')
		),
		'doNotCopyRecords'            => true
	),
	'list'        => array
	(
		'sorting'    => array
		(
			'mode'                    => 4,
			'headerFields'            => array('title', 'priority', 'deadline'),
			'fields'                  => array('tstamp'),
			'flag'                    => 6,
			'panelLayout'             => 'limit',
			'child_record_callback'   => array('TaskComment', 'renderComment')
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_task_comment']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif',
				'button_callback'     => array('TaskComment', 'editButton')
			)
		)
	),
	'palettes'    => array
	(
		'__selector__'                => array('changeCustomerProject', 'changePriority', 'changeTitle', 'changeDeadline', 'keeptime'),
		'default'                     => '{settings_legend:hide}, changeCustomerProject, changePriority, changeTitle, changeDeadline;'
			. '{comment_legend}, toStatus, toUser, comment;'
			. '{timekeeping_legend}, keeptime;'
	),
	'subpalettes' => array
	(
		'changeCustomerProject' => 'toCustomer,toProject',
		'changePriority'        => 'priority',
		'changeTitle'           => 'title',
		'changeDeadline'        => 'deadline',
		'keeptime' => 'hours, minutes, toWorkPackage'
	),
	'fields'      => array
	(
		'user'                  => array
		(
			'default' => $this->User->id
		),
		'changeCustomerProject' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_task_comment']['changeCustomerProject'],
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'           => 'clr',
			                                   'submitOnChange'     => true)
		),
		'toCustomer'            => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_task_comment']['toCustomer'],
			'inputType'               => 'select',
			'options_callback'        => array('Customer', 'getCustomerOptions'),
			'eval'                    => array('tl_class'           => 'w50 clr',
			                                   'includeBlankOption' => true,
			                                   'submitOnChange'     => true),
			'passToTask'              => 'changeCustomer'
		),
		'toProject'             => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_task_comment']['toProject'],
			'inputType'               => 'select',
			'eval'                    => array('tl_class'           => 'w50',
			                                   'includeBlankOption' => true),
			'options_callback'        => array('Project', 'getProjectsOfCustomer'),
			'passToTask'              => 'changeProject'
		),
		'changePriority'        => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_task_comment']['changePriority'],
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'           => 'clr',
			                                   'submitOnChange'     => true)
		),
		'priority'              => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_task_comment']['priority'],
			'inputType'               => 'select',
			'options_callback'        => array('Task', 'getPriorityOptions'),
			'passToTask'              => 'changePriority'
		),
		'changeTitle'           => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_task_comment']['changeTitle'],
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'           => 'clr',
			                                   'submitOnChange'     => true)
		),
		'title'                 => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_task_comment']['title'],
			'inputType'               => 'text',
			'exclude'			     => true,
			'search'                  => true,
			'eval'                    => array('maxlength'=> 250),
			'passToTask'              => 'changeTitle'
		),
		'changeDeadline'        => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_task_comment']['changeDeadline'],
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'           => 'clr',
			                                   'submitOnChange'     => true)
		),
		'deadline'              => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_task_comment']['deadline'],
			'default'                 => time(),
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 8,
			'inputType'               => 'text',
			'exclude'			     => true,
			'eval'                    => array('rgxp'      => 'date',
			                                   'datepicker'=> $this->getDatePickerString(),
			                                   'tl_class'  => 'wizard'),
			'passToTask'              => 'changeDeadline'
		),
		'toStatus'              => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_task_comment']['toStatus'],
			'filter'                  => true,
			'inputType'               => 'select',
			'exclude'			     => true,
			'foreignKey'              => 'tl_li_task_status.title',
			'eval'                    => array('includeBlankOption'=> true,
			                                   'tl_class'          => 'w50',
			                                   'mandatory'         => true),
			'passToTask'              => true
		),
		'toUser'                => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_task_comment']['toUser'],
			'inputType'               => 'select',
			'foreignKey'              => 'tl_user.username',
			'eval'                    => array('tl_class'=> 'w50'),
			'passToTask'              => true
		),
		'comment'               => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_task_comment']['comment'],
			'inputType'               => 'textarea',
			'eval'                    => array('tl_class'=> 'clr',
			                                   'rte'     => 'tinyMCE')
		),
		'keeptime' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_task_comment']['keeptime'],
			'inputType'               => 'checkbox',
			'eval' => array('submitOnChange' => true)
		),
		'hours'             => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_task_comment']['hours'],
			'inputType'               => 'text',
			'eval' => array('rgxp'=> 'digit', 'tl_class' => 'w50')
		),
		'minutes' => array
		(
			'label'		=> &$GLOBALS['TL_LANG']['tl_li_task_comment']['minutes'],
			'inputType' => 'text',
			'eval'		=> array('rgxp' => 'digit', 'maxlength' => '2', 'tl_class' => 'w50')
		),
        'toWorkPackage' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_li_task_comment']['toWorkPackage'],
			'inputType'			=> 'select',
			'exclude'   		=> true,
			'options_callback'	=> array('WorkPackage', 'getWorkPackages'),
			'eval'				=> array('mandatory' => true, 'includeBlankOption' => true, 'tl_class' => 'w50')
		)
	)
);
