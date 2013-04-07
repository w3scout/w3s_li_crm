<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
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
	    'dataContainer'             => 'Table',
		'enableVersioning'          => true,
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary'
            )
        )
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                  => 1,
			'fields'                => array('toProductType', 'number'),
			'flag'                  => 1
		),
		'label' => array
		(
			'fields'                => array('number', 'title'),
			'format'                => '%s - %s'
		),
		'global_operations' => array
		(
            'all' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'              => 'act=select',
				'class'             => 'header_edit_all',
				'attributes'        => 'onclick="Backend.getScrollOffset();"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_product']['edit'],
				'href'              => 'act=edit',
				'icon'              => 'edit.gif'
			),
			'copy' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_product']['copy'],
				'href'              => 'act=copy',
				'icon'              => 'copy.gif'
			),
			'delete' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_product']['delete'],
				'href'              => 'act=delete',
				'icon'              => 'delete.gif',
				'attributes'        => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_product']['show'],
				'href'              => 'act=show',
				'icon'              => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'              => array(''),
		'default'                   => '{product_legend},toProductType,unit,number,title;
										{price_legend},price,toTax,currency;'
	),

	// Fields
	'fields' => array
	(
        'id' => array(
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'toProductType' => array
        (
            'label'                 => &$GLOBALS['TL_LANG']['tl_li_product']['toProductType'],
            'inputType'             => 'select',
            'exclude'   			=> true,
            'foreignKey'            => 'tl_li_product_type.title',
            'eval'                  => array('mandatory'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'unit' => array
        (
            'label'                 => &$GLOBALS['TL_LANG']['tl_li_product']['unit'],
            'inputType'             => 'select',
            'exclude'   			=> true,
            'options_callback'      => array('Product', 'getUnitOptions'),
            'eval'                  => array('mandatory'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
            'sql'                     => "varchar(20) NOT NULL default 'unit'"
        ),
        'number' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_product']['number'],
			'inputType'             => 'text',
			'exclude'   			=> true,
			'eval'                  => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default 'unit'"
		),
        'title' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_product']['title'],
			'inputType'             => 'text',
			'exclude'   			=> true,
			'eval'                  => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default 'unit'"
		),
		'price' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_product']['price'],
			'inputType'             => 'text',
			'exclude'   			=> true,
			'eval'                  => array('mandatory'=>true, 'maxlength'=>12, 'tl_class'=>'w50', 'rgxp'=>'digit'),
            'sql'                     => "double NOT NULL default '0'"
		),
        'toTax' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_product']['toTax'],
			'inputType'             => 'select',
			'exclude'   			=> true,
			'options_callback'		=> array('CompanySettings', 'getTaxOptions'),
			'eval'                  => array('mandatory'=>true, 'chosen'=>true, 'maxlength'=>3, 'tl_class'=>'w50', 'rgxp'=>'digit'),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
        'currency' => array
        (
            'label'                 => &$GLOBALS['TL_LANG']['tl_li_product']['currency'],
            'inputType'             => 'select',
            'exclude'               => true,
            'options_callback'      => array('CurrencyHelper', 'getCurrencyOptions'),
            'eval'                  => array('mandatory' => true, 'chosen'=>true, 'tl_class' => 'w50'),
            'sql'                     => "varchar(3) NOT NULL default ''"
        )
	)
);
