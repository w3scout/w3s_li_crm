<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */
$GLOBALS['TL_DCA']['tl_li_work_package'] = array
(
	'config' => array
	(
		'dataContainer'     => 'Table',
		'enableVersioning'  => true
	),
	'list' => array
	(
		'sorting' => array
		(
			'mode'      => 1,
			'fields'    => array('toCustomer'),
            'flag'      => 11,
            'panelLayout' => 'filter;search,limit'
		),
		'label' => array
		(
            'fields'            => array('title'),
            'group_callback' => array('WorkPackage', 'getGroupLabel'),
            'label_callback' => array('WorkPackage', 'getLabel')
		),
		'global_operations' => array
		(
            'all' => array
			(
				'label'         => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'          => 'act=select',
				'class'         => 'header_edit_all',
				'attributes'    => 'onclick="Backend.getScrollOffset();"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_li_work_package']['edit'],
				'href'  => 'act=edit',
				'icon'  => 'edit.gif'
			),
			'copy' => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_li_work_package']['copy'],
				'href'  => 'act=copy',
				'icon'  => 'copy.gif'
			),
			'delete' => array
			(
				'label'         => &$GLOBALS['TL_LANG']['tl_li_work_package']['delete'],
				'href'          => 'act=delete',
				'icon'          => 'delete.gif',
				'attributes'    => 'onclick="if (!confirm(\''.$GLOBALS['TL_LANG']['MSC']['deleteConfirm'].'\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_li_work_package']['show'],
				'href'  => 'act=show',
				'icon'  => 'show.gif'
			)
		)
	),
	'palettes' => array
	(
		'__selector__'  => array('isExternal'),
		'default'       => '{package_legend},title,hourLimit,toHourlyWage;{settings_legend},isExternal;'
	),
	'subpalettes' => array
	(
		'isExternal' => 'toCustomer,toProject,printOnInvoice'
	),
	'fields' => array
	(
		'title' => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_li_work_package']['title'],
			'inputType' => 'text',
			'exclude'   => true,
            'search'    => true,
			'eval'      => array('mandatory' => true, 'maxlength' => 250, 'tl_class' => 'w50')
		),
		'hourLimit' => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_li_work_package']['hourLimit'],
			'inputType' => 'text',
			'exclude'   => true,
			'eval'      => array('rgxp' => 'digit', 'maxlength' => 4)
		),
        'toHourlyWage' => array
        (
            'label'             => &$GLOBALS['TL_LANG']['tl_li_work_package']['toHourlyWage'],
            'inputType'         => 'select',
            'exclude'   		=> true,
            'filter'            => true,
            'foreignKey'        => 'tl_li_hourly_wage.title',
            'eval'              => array('mandatory' => true, 'includeBlankOption' => true, 'tl_class'=>'clr'),
            'options_callback'  => array('HourlyWage', 'getHourlyWagesList'),
        ),
		'isExternal' => array
        (
        	'label'     => &$GLOBALS['TL_LANG']['tl_li_work_package']['isExternal'],
        	'inputType' => 'checkbox',
        	'exclude'   => true,
            'filter'    => true,
        	'eval'      => array('submitOnChange' => true, 'tl_class' => 'clr')
        ),
        'toCustomer' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_work_package']['toCustomer'],
			'inputType'               => 'select',
			'exclude'   			  => true,
			'options_callback'        => array('Customer', 'getCustomerOptions'),
			'eval'                    => array('mandatory' => true, 'tl_class' => 'w50','includeBlankOption' => true,
                'submitOnChange' => true)
		),
        'toProject' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_work_package']['toProject'],
			'inputType'               => 'select',
			'exclude'   			  => true,
			'eval'                    => array('tl_class' => 'w50', 'includeBlankOption' => true),
			'options_callback'        => array('Project', 'getProjectsOfCustomer')
		),
		'printOnInvoice' => array
		(
			'label'             => &$GLOBALS['TL_LANG']['tl_li_work_package']['printOnInvoice'],
			'inputType'         => 'checkbox',
			'exclude'   		=> true,
            'filter'            => true,
			'eval'              => array('tl_class'=>'w50'),
		)
	)
);
