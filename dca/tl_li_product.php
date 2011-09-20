<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */
$GLOBALS['TL_DCA']['tl_li_product'] = array
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
			'fields'                  => array('toProductType'),
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
	'palettes' => array
	(
		'__selector__'                => array(''),
		'default'                     => '{product_legend}, title, toProductType, price, currency, taxRate;'
	),
	'fields' => array
	(
		'toProductType' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_product']['toProductType'],
			'inputType'               => 'select',
			'foreignKey'              => 'tl_li_product_type.title',
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'clr', 'submitOnChange'=>true, 'tl_class'=>'w50')
		),
        'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_product']['title'],
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50')
		),
		'price' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_product']['price'],
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>12, 'tl_class'=>'w50', 'rgxp'=>'digit')
		),
        'taxRate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_product']['taxRate'],
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>3, 'tl_class'=>'w50', 'rgxp'=>'digit')
		),
        'currency' => array
        (
            'label'             => &$GLOBALS['TL_LANG']['tl_li_product']['currency'],
            'inputType'         => 'select',
            'options_callback'  => array('Currency', 'getCurrencyOptions'),
            'eval'              => array('tl_class' => 'w50', 'includeBlankOption' => true)
        )
	)
);
