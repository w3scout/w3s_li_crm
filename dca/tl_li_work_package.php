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
			'fields'    => array('toProject'),
            'flag'      => 1
		),
		'label' => array
		(
            'fields'            => array('title'),
            'label_callback'    => array('WorkPackage', 'getLabel'),
            'group_callback'    => array('WorkPackage', 'getGroupLabel'),
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
		'isExternal' => 'toProject,printOnInvoice'
	),
	'fields' => array
	(
		'title' => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_li_work_package']['title'],
			'inputType' => 'text',
			'eval'      => array('mandatory' => true, 'maxlength' => 250, 'tl_class' => 'w50')
		),
		'hourLimit' => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_li_work_package']['hourLimit'],
			'inputType' => 'text',
			'eval'      => array('rgxp' => 'digit', 'maxlength' => 4)
		),
        'toHourlyWage' => array
        (
            'label'             => &$GLOBALS['TL_LANG']['tl_li_work_package']['toHourlyWage'],
            'inputType'         => 'select',
            'foreignKey'        => 'tl_li_hourly_wage.title',
            'eval'              => array('mandatory' => true, 'includeBlankOption' => true, 'tl_class'=>'clr'),
            'options_callback'  => array('HourlyWage', 'getHourlyWagesList'),
        ),
		'isExternal' => array
        (
        	'label'     => &$GLOBALS['TL_LANG']['tl_li_work_package']['isExternal'],
        	'inputType' => 'checkbox',
        	'eval'      => array('submitOnChange' => true, 'tl_class' => 'clr')
        ),
        'toProject' => array
		(
			'label'             => &$GLOBALS['TL_LANG']['tl_li_work_package']['toProject'],
            'foreignKey'        => 'tl_li_project.title',
			'inputType'         => 'select',
			'options_callback'  => array('Project', 'getProjectsByCustomerList'),
			'eval'              => array('mandatory' => true, 'tl_class' => 'w50')
		),
		'printOnInvoice' => array
		(
			'label'             => &$GLOBALS['TL_LANG']['tl_li_work_package']['printOnInvoice'],
			'inputType'         => 'checkbox',
			'eval'              => array('tl_class'=>'w50'),
		)
	)
);
