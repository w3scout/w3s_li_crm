<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * PHP version 5
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */

/**
 * Table tl_li_service
 */
$GLOBALS['TL_DCA']['tl_li_service'] = array
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
			'mode'                    => 1,
			'fields'                  => array('title'),
			'flag'                    => 1
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
				'label'               => &$GLOBALS['TL_LANG']['tl_li_service']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_service']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_service']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_service']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array(''),
		'default'                     => '{service_legend}, toCustomer, toProject, toServiceType, title, price;'
	),

	// Subpalettes
	'subpalettes' => array
	(
		''                            => ''
	),

	// Fields
	'fields' => array
	(
		'toCustomer' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_service']['toCustomer'],
			'inputType'               => 'select',
			'options_callback'        => array('Customer', 'getCustomerWithProjectsOptions'),
			'eval'                    => array('mandatory'=>true, 'submitOnChange'=>true, 'tl_class'=>'w50', 'includeBlankOption'=>true)
		),
        'toProject' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_service']['toProject'],
			'inputType'               => 'select',
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50'),
			'options_callback'        => array('Project', 'getProjectsFromCustomerOptions')
		),
		'toServiceType' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_service']['toServiceType'],
			'inputType'               => 'select',
			'foreignKey'              => 'tl_li_service_type.title',
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'clr', 'submitOnChange'=>true)
		),
        'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_service']['title'],
			'inputType'               => 'text',
			'default'                 => '-',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50')
		),
		'price' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_service']['price'],
			'inputType'               => 'text',
			'load_callback'           => array(array('Service', 'getDefaultPrice')),
			'eval'                    => array('mandatory'=>true, 'maxlength'=>12, 'tl_class'=>'w50', 'rgxp'=>'digit', 'alwaysSave'=>true)
		)
	)
);

?>