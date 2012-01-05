<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */
$GLOBALS['TL_DCA']['tl_li_date'] = array
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
			'fields'                  => array('subject'),
			'flag'                    => 1,
			'panelLayout'             => 'filter;sort,search,limit'
		),
		'label' => array
		(
			'fields'                  => array('subject'),
			//'label_callback'          => array('Date', 'renderLabel')
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
				'label'               => &$GLOBALS['TL_LANG']['tl_li_date']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_date']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_date']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			)
		)
	),
	'palettes' => array
	(
		'__selector__'                => array(''),
		'default'                     => '{date_legend},toCustomer,creator,subject,toTask,participants,place,note,repetition,interval,color;{time_legend},startDate,endDate,startTime,endTime;{visibility_legend},private;'
	),
	'fields' => array
	(
        'toCustomer' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_date']['toCustomer'],
			'inputType'               => 'select',
			'exclude'   			  => true,
			'options_callback'        => array('Customer', 'getCustomerOptions'),
			'eval'                    => array('tl_class' => 'w50','includeBlankOption' => true, 'submitOnChange' => true)
		),
        'creator' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_date']['creator'],
			'inputType'               => 'select',
			'foreignKey'			  => 'tl_user.name',
			'exclude'   			  => true,
			'eval'                    => array('tl_class' => 'w50', 'includeBlankOption' => true)
		),
        'subject' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_date']['subject'],
			'inputType'               => 'text',
			'exclude'   			  => true,
			'search'                  => true,
			'eval'                    => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50')
		),
		'toTask' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_date']['toTask'],
			'inputType'               => 'select',
			'options_callback'		  => array('Task', 'getTaskOptions'),
			'exclude'   			  => true,
			'eval'                    => array('tl_class' => 'w50', 'includeBlankOption' => true)
		),
		'participants' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_date']['participants'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkboxWizard',
			'foreignKey'              => 'tl_user.name',
			'eval'                    => array('tl_class'=>'clr', 'multiple'=>true)
		),
		'note' => array
		(
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_date']['note'],
			'search'                  => true,
			'inputType'               => 'textarea',
			'exclude'   			  => true,
			'eval'                    => array('tl_class'=>'clr', 'rte'=>'tinyMCE')
        ),
		'private' => array
		(
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_date']['private'],
			'inputType'               => 'checkbox',
			'exclude'   			  => true,
			'filter'                  => true
        )
	)
);