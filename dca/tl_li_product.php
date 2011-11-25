<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * PHP version 5
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */

/**
 * Table tl_li_product
 */
$GLOBALS['TL_DCA']['tl_li_product'] = array
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
			'fields'                  => array('toProductType', 'number'),
			'flag'                    => 1
		),
		'label' => array
		(
			'fields'                  => array('number', 'title'),
			'format'                  => '%s - %s'
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
				'label'               => &$GLOBALS['TL_LANG']['tl_li_product']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_product']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_product']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_product']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array(''),
		'default'                     => '{product_legend},toProductType,number,title;{price_legend},price,toTax,currency;'
	),

	// Fields
	'fields' => array
	(
		'toProductType' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_product']['toProductType'],
			'inputType'               => 'select',
			'exclude'   			  => true,
			'foreignKey'              => 'tl_li_product_type.title',
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'clr', 'submitOnChange'=>true, 'tl_class'=>'w50',)
		),
		'number' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_product']['number'],
			'inputType'               => 'text',
			'exclude'   			  => true,
			'eval'                    => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50')
		),
        'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_product']['title'],
			'inputType'               => 'text',
			'exclude'   			  => true,
			'eval'                    => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50')
		),
		'price' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_product']['price'],
			'inputType'               => 'text',
			'exclude'   			  => true,
			'eval'                    => array('mandatory'=>true, 'maxlength'=>12, 'tl_class'=>'w50', 'rgxp'=>'digit')
		),
        'toTax' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_product']['toTax'],
			'inputType'               => 'select',
			'exclude'   			  => true,
			'options_callback'		  => array('CompanySettings', 'getTaxOptions'),
			'eval'                    => array('mandatory'=>true, 'maxlength'=>3, 'tl_class'=>'w50', 'rgxp'=>'digit')
		),
        'currency' => array(
            'label' => &$GLOBALS['TL_LANG']['tl_li_product']['currency'],
            'inputType' => 'select',
            'exclude' => true,
            'options_callback' => array('CurrencyHelper', 'getCurrencyOptions'),
            'eval' => array('mandatory' => true, 'tl_class' => 'w50'),
        )
	)
);

?>