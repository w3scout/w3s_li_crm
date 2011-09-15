<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */
$GLOBALS['TL_DCA']['tl_li_task_reminder'] = array
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
			'mode'                    => 2,
			'fields'                  => array('toTask'),
			'flag'                    => 1,
			'panelLayout'             => 'filter;sort,limit'
		),
		'label' => array
		(
			'fields'                  => array('toTask'),
			'label_callback'          => array('TaskReminder', 'renderLabel')
		),
		'global_operations' => array
		(
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
				'label'               => &$GLOBALS['TL_LANG']['tl_li_task_reminder']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_task_reminder']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_task_reminder']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_task_reminder']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),
	'palettes' => array
	(
		'__selector__'                => array('remindOnce', 'remindRepeatedly'),
		'default'                     => '{reminder_legend}, toTask; {once_legend}, remindOnce; {repeatedly_legend}, remindRepeatedly;'
	),
	'subpalettes' => array
	(
		'remindOnce'                  => 'remindDate',
		'remindRepeatedly'            => 'remindInterval'
	),
	'fields' => array
	(
        'toTask' => array
		(
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_task_reminder']['toTask'],
			'inputType'               => 'select',
            'options_callback'        => array('TaskReminder', 'getTaskOptions'),
			'eval'                    => array('tl_class' => 'w50', 'includeBlankOption' => true)
        ),
        'remindOnce' => array
		(
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_task_reminder']['remindOnce'],
			'inputType'               => 'checkbox',
			'filter'                  => true,
			'eval'                    => array('submitOnChange' => true)
        ),
        'remindDate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_task_reminder']['remindDate'],
			'default'                 => time(),
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 8,
			'inputType'               => 'text',
			'load_callback'           => array (array('TaskReminder', 'getRemindDate')),
			'eval'                    => array('rgxp' => 'date', 'datepicker' => $this->getDatePickerString(),
                                               'tl_class' => 'w50 wizard')
		),
        'remindRepeatedly' => array
		(
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_task_reminder']['remindRepeatedly'],
			'inputType'               => 'checkbox',
			'filter'                  => true,
			'eval'                    => array('submitOnChange' => true)
        ),
        'remindInterval' => array
		(
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_task_reminder']['remindInterval'],
			'filter'                  => true,
			'inputType'               => 'select',
            'options'                 => array('daily', 'weekly', 'monthly', 'yearly'),
            'reference'               => &$GLOBALS['TL_LANG']['tl_li_task_reminder']['remindInterval'],
			'eval'                    => array('tl_class' => 'w50')
        )
	)
);

?>