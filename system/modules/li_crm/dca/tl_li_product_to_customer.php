<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */

/**
 * Table tl_li_product_to_customer
 */
$GLOBALS['TL_DCA']['tl_li_product_to_customer'] = array
(
	// Config
	'config' => array
	(
	    'dataContainer'             => 'Table',
		'enableVersioning'          => false,
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary'
            )
        )
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'              => array(''),
		'default'                   => '{product_legend},toCustomer,toProject,number,toProduct,saleDate,note;'
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
        'toCustomer' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_product_to_customer']['toCustomer'],
			'inputType'             => 'select',
			'exclude'   			=> true,
			'options_callback'      => array('LiCRM\Customer', 'getCustomerOptions'),
			'eval'                  => array('mandatory' => true, 'tl_class' => 'w50', 'chosen'=>true, 'includeBlankOption' => true, 'submitOnChange'=>true),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
        'toProject' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_product_to_customer']['toProject'],
			'inputType'             => 'select',
			'exclude'   			=> true,
			'options_callback'      => array('LiCRM\Project', 'getProjectsOfCustomer'),
            'eval'                  => array('tl_class' => 'w50', 'chosen'=>true, 'includeBlankOption' => true),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
        'number' => array
        (
            'label'                 => &$GLOBALS['TL_LANG']['tl_li_product_to_customer']['number'],
            'inputType'             => 'text',
            'exclude'   			=> true,
            'eval'                  => array('mandatory'=>true, 'maxlength'=>12, 'tl_class'=>'w50', 'rgxp'=>'digit'),
            'sql'                     => "int(10) unsigned NOT NULL default '1'"
        ),
		'toProduct' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_product_to_customer']['toProduct'],
			'inputType'             => 'select',
			'exclude'   			=> true,
			'options_callback'      => array('LiCRM\Product', 'getProductsList'),
            'eval'                  => array('mandatory' => true, 'chosen'=>true, 'tl_class' => 'w50', 'includeBlankOption' => true),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
        'saleDate' => array
        (
            'label'                 => &$GLOBALS['TL_LANG']['tl_li_product_to_customer']['saleDate'],
            'default'               => time(),
            'filter'                => true,
            'sorting'               => true,
            'flag'                  => 8,
            'inputType'             => 'text',
            'exclude'   			=> true,
            'eval'                  => array('mandatory'=>true, 'rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
            'sql'                     => "varchar(10) NOT NULL default ''"
        ),
        'note' => array
        (
            'label'                 => &$GLOBALS['TL_LANG']['tl_li_product_to_customer']['note'],
            'inputType'             => 'textarea',
            'exclude'   			=> true,
            'eval'                  => array('rte'=>'tinyMCE', 'tl_class'=>'clr'),
            'sql'                     => "text NOT NULL"
        )
	)
);
