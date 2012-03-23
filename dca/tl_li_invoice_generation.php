<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * PHP version 5
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */

/**
 * Table tl_li_invoice_generation
 */
$GLOBALS['TL_DCA']['tl_li_invoice_generation'] = array
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
			'fields'                  => array('toCustomer'),
			'panelLayout'             => 'filter;sort,search,limit'
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
				'label'               => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array(''),
		'default'                     => '{invoice_legend},toCustomer,toCategory,title,alias,currency,maturity;
		                                  {generation_legend},headline,toTemplate,toAddress,descriptionBefore,servicePositions,productPositions,hourPositions,discount,earlyPaymentDiscount,descriptionAfter;
		                                  {settings_legend},publishImmediately,sendImmediately;'
	),

	// Subpalettes
	'subpalettes' => array
	(
	),

	// Fields
	'fields' => array
	(
        'toCustomer' => array
		(
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['toCustomer'],
			'filter'                  => true,
			'inputType'               => 'select',
			'exclude'   			  => true,
            'options_callback'        => array('Customer', 'getCustomerOptions'),
			'eval'                    => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50', 'submitOnChange'=>true)
        ),
        'toCategory' => array
		(
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['toCategory'],
			'filter'                  => true,
			'inputType'               => 'select',
			'exclude'   			  => true,
            'foreignKey'              => 'tl_li_invoice_category.title',
			'eval'                    => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50')
        ),
        'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['title'],
			'inputType'               => 'text',
			'exclude'   			  => true,
			'search'                  => true,
			'flag'                    => 1,
			'eval'                    => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50')
		),
		'alias' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['alias'],
			'search'                  => true,
			'inputType'               => 'text',
			'exclude'   			  => true,
			'eval'                    => array('rgxp'=>'alnum', 'unique'=>true, 'spaceToUnderscore'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('Invoice', 'generateAlias')
			)
		),
        'currency' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['currency'],
            'inputType'               => 'select',
            'exclude'                 => true,
            'options_callback'        => array('CurrencyHelper', 'getCurrencyOptions'),
            'eval'                    => array('mandatory'=>true, 'chosen'=>true, 'tl_class'=>'w50', 'submitOnChange'=>true),
        ),
		'maturity' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['maturity'],
			'inputType'               => 'text',
			'exclude'   			  => true,
			'eval'                    => array('tl_class'=>'w50')
		),
        'headline' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['headline'],
			'inputType'               => 'text',
			'exclude'   			  => true,
			'search'                  => true,
			'flag'                    => 1,
			'eval'                    => array('maxlength'=>250, 'tl_class'=>'clr')
		),
        'toTemplate' => array
		(
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['toTemplate'],
			'inputType'               => 'select',
			'exclude'   			  => true,
			'foreignKey'              => 'tl_li_invoice_template.title',
			'eval'                    => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50', 'mandatory'=>true)
        ),
        'toAddress' => array
		(
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['toAddress'],
			'inputType'               => 'select',
			'exclude'   			  => true,
			'options_callback'        => array('Invoice', 'getAddressOptions'),
			'eval'                    => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50', 'mandatory'=>true)
        ),
        'descriptionBefore' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['descriptionBefore'],
            'inputType'               => 'textarea',
            'exclude'   			  => true,
			'eval'                    => array('rte'=>'tinyMCE', 'tl_class'=>'clr')
		),
        'servicePositions' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['servicePositions'],
			'inputType'               => 'multiColumnWizard',
			'exclude'   			  => true,
			'eval'                    => array(
				'columnFields' => array
				(
					'quantity' => array
					(
						'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['position_quantity'],
						'exclude'           => true,
						'inputType'         => 'text',
						'eval' 				=> array('style'=>'width:40px;text-align:center;')
					),
					'unit' => array
					(
						'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['position_unit'],
						'exclude'           => true,
						'inputType'         => 'select',
						'options_callback' 	=> array('Invoice', 'getUnitOptions'),
						'eval' 				=> array('style'=>'width:80px;', 'chosen'=>true)
					),
					'item' => array
					(
						'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['position_item'],
						'exclude'           => true,
						'inputType'         => 'select',
						'options_callback'  => array('Invoice', 'getServiceOptions'),
						'eval' 				=> array('style'=>'width:160px;', 'chosen'=>true, 'includeBlankOption'=>true)
					),
					'title' => array
					(
						'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['position_label'],
						'exclude'           => true,
						'inputType'         => 'text',
						'eval' 				=> array('style'=>'width:300px;')
					)
				)
			)
		),
		'productPositions' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['productPositions'],
			'inputType'               => 'multiColumnWizard',
			'exclude'   			  => true,
			'eval'                    => array(
				'columnFields' => array
				(
					'quantity' => array
					(
						'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['position_quantity'],
						'exclude'           => true,
						'inputType'         => 'text',
						'eval' 				=> array('style'=>'width:40px;text-align:center;')
					),
					'unit' => array
					(
						'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['position_unit'],
						'exclude'           => true,
						'inputType'         => 'select',
						'options_callback' 	=> array('Invoice', 'getUnitOptions'),
						'eval' 				=> array('style'=>'width:80px;', 'chosen'=>true)
					),
					'item' => array
					(
						'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['position_item'],
						'exclude'           => true,
						'inputType'         => 'select',
						'options_callback'  => array('Invoice', 'getProductOptions'),
						'eval' 				=> array('style'=>'width:160px;', 'chosen'=>true, 'includeBlankOption'=>true)
					),
					'title' => array
					(
						'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['position_label'],
						'exclude'           => true,
						'inputType'         => 'text',
						'eval' 				=> array('style'=>'width:300px;')
					)
				)
			)
		),
		'hourPositions' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['hourPositions'],
			'inputType'               => 'multiColumnWizard',
			'exclude'   			  => true,
			'eval'                    => array(
				'columnFields' => array
				(
					'quantity' => array
					(
						'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['position_quantity'],
						'exclude'           => true,
						'inputType'         => 'text',
						'eval' 				=> array('style'=>'width:40px;text-align:center;')
					),
					'item' => array
					(
						'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['position_item'],
						'exclude'           => true,
						'inputType'         => 'select',
						'options_callback'  => array('Invoice', 'getHourOptions'),
						'eval' 				=> array('style'=>'width:247px;', 'chosen'=>true, 'includeBlankOption'=>true)
					),
					'title' => array
					(
						'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['position_label'],
						'exclude'           => true,
						'inputType'         => 'text',
						'eval' 				=> array('style'=>'width:300px;')
					)
				)
			)
		),
        'discount' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['discount'],
            'inputType'               => 'inputUnit',
            'options'                 => array('percent', 'value'),
            'reference'               => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['discountOptions'],
            'exclude'   			  => true
        ),
        'earlyPaymentDiscount' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['earlyPaymentDiscount'],
            'inputType'               => 'text',
            'exclude'   			  => true,
            'eval'                    => array('tl_class'=>'long')
        ),
        'descriptionAfter' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['descriptionAfter'],
            'inputType'               => 'textarea',
            'exclude'   			  => true,
			'eval'                    => array('rte'=>'tinyMCE', 'tl_class'=>'clr')
		),
		'publishImmediately' => array
		(
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['publishImmediately'],
			'inputType'               => 'checkbox',
			'exclude'   			  => true,
			'filter'                  => true,
            'eval'                    => array('tl_class'=>'w50')
        ),
        'sendImmediately' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice_generation']['sendImmediately'],
            'inputType'               => 'checkbox',
            'exclude'   			  => true,
            'filter'                  => true,
            'eval'                    => array('tl_class'=>'w50')
        )
	)
);