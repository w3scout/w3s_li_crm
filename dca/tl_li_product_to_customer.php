<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */
$GLOBALS['TL_DCA']['tl_li_product_to_customer'] = array
(
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => false
	),

	'palettes' => array
	(
		'__selector__'                => array(''),
		'default'                     => '{product_legend},toCustomer,toProject,number,toProduct,saleDate,note;'
	),

	'fields' => array
	(
        'toCustomer' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_product_to_customer']['toCustomer'],
			'inputType'               => 'select',
			'exclude'   			  => true,
			'options_callback'        => array('Customer', 'getCustomerOptions'),
			'eval'                    => array('mandatory' => true, 'tl_class' => 'w50', 'chosen'=>true, 'includeBlankOption' => true, 'submitOnChange'=>true)
		),
        'toProject' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_product_to_customer']['toProject'],
			'inputType'               => 'select',
			'exclude'   			  => true,
			'options_callback'        => array('Project', 'getProjectsOfCustomer'),
            'eval'                    => array('tl_class' => 'w50', 'chosen'=>true, 'includeBlankOption' => true)
		),
        'number' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_product_to_customer']['number'],
            'inputType'               => 'text',
            'exclude'   			  => true,
            'eval'                    => array('mandatory'=>true, 'maxlength'=>12, 'tl_class'=>'w50', 'rgxp'=>'digit')
        ),
		'toProduct' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_product_to_customer']['toProduct'],
			'inputType'               => 'select',
			'exclude'   			  => true,
			'options_callback'        => array('Product', 'getProductsList'),
            'eval'                    => array('mandatory' => true, 'chosen'=>true, 'tl_class' => 'w50', 'includeBlankOption' => true)
		),
        'saleDate' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_product_to_customer']['saleDate'],
            'default'                 => time(),
            'filter'                  => true,
            'sorting'                 => true,
            'flag'                    => 8,
            'inputType'               => 'text',
            'exclude'   			  => true,
            'eval'                    => array('mandatory'=>true, 'rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard')
        ),
        'note' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_product_to_customer']['note'],
            'inputType'               => 'textarea',
            'exclude'   			  => true,
            'eval'                    => array('rte'=>'tinyMCE', 'tl_class'=>'clr')
        ),
	)
);
