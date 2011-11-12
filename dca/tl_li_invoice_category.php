<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * PHP version 5
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */

/**
 * Table tl_li_invoice_category
 */
$GLOBALS['TL_DCA']['tl_li_invoice_category'] = array
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
			'fields'                  => array('orderNumber'),
			'flag'                    => 11
		),
		'label' => array
		(
			'fields'                  => array('title'),
			'format'                  => '%s',
			'group_callback'          => array('InvoiceCategory', 'renderGroup')
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
				'label'               => &$GLOBALS['TL_LANG']['tl_li_invoice_category']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_invoice_category']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_invoice_category']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_invoice_category']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array(''),
		'default'                     => '{category_legend}, title, orderNumber;'
	),

	// Subpalettes
	'subpalettes' => array
	(
		''                            => ''
	),

	// Fields
	'fields' => array
	(
        'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice_category']['title'],
			'inputType'               => 'text',
			'exclude'   			  => true,
			'eval'                    => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50')
		),
		'orderNumber' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice_category']['orderNumber'],
			'inputType'               => 'text',
			'exclude'   			  => true,
			'eval'                    => array('mandatory'=>true, 'maxlength'=>12, 'tl_class'=>'w50', 'rgxp'=>'digit')
		),
	)
);

?>