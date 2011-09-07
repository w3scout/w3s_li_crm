<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * PHP version 5
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */

/**
 * Table tl_li_project 
 */
$GLOBALS['TL_DCA']['tl_li_work_package'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => true
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 2,
			'fields'                  => array('toCustomer')
		),
		'label' => array
		(
			'fields'                  => array('title'),
			'format'                  => '%s'
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
				'label'               => &$GLOBALS['TL_LANG']['tl_li_work_package']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_work_package']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_work_package']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_work_package']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array('isExternal'),
		'default'                     => '{package_legend}, title, hourLimit;{settings_legend}, isExternal;'
	),

	// Subpalettes
	'subpalettes' => array
	(
		'isExternal'                  => 'toCustomer, toProject'
	),

	// Fields
	'fields' => array
	(
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_work_package']['title'],
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50')
		),
		'hourLimit' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_work_package']['hourLimit'],
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'digit', 'maxlength'=>4)
		),
		'isExternal' => array
        (
        	'label'                   => &$GLOBALS['TL_LANG']['tl_li_work_package']['isExternal'],
        	'inputType'               => 'checkbox',
        	'eval'                    => array('submitOnChange'=>true)
        ),
        'toCustomer' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_work_package']['toCustomer'],
			'inputType'               => 'select',
			'options_callback'        => array('Customer', 'getCustomerWithProjectsOptions'),
			'eval'                    => array('mandatory'=>true, 'submitOnChange'=>true, 'tl_class'=>'w50', 'includeBlankOption'=>true)
		),
        'toProject' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_work_package']['toProject'],
			'inputType'               => 'select',
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50'),
			'options_callback'        => array('Project', 'getProjectsFromCustomerOptions')
		),
	)
);

?>