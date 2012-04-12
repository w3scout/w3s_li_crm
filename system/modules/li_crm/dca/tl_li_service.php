<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
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
	    'dataContainer'             => 'Table',
		'enableVersioning'          => true
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                  => 1,
			'fields'                => array('title'),
			'flag'                  => 1
		),
		'label' => array
		(
			'fields'                => array('title'),
			'format'                => '%s'
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
				'label'             => &$GLOBALS['TL_LANG']['tl_li_service']['edit'],
				'href'              => 'act=edit',
				'icon'              => 'edit.gif'
			),
			'copy' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_service']['copy'],
				'href'              => 'act=copy',
				'icon'              => 'copy.gif'
			),
			'delete' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_service']['delete'],
				'href'              => 'act=delete',
				'icon'              => 'delete.gif',
				'attributes'        => 'onclick="if (!confirm(\''.$GLOBALS['TL_LANG']['MSC']['deleteConfirm'].'\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_service']['show'],
				'href'              => 'act=show',
				'icon'              => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'              => array('repetition'),
		'default'                   => '{service_legend},toCustomer,toProject,title,unit,toServiceType;{price_legend},price,toTax,currency;{date_legend},startDate,endDate,repetition;'
	),
	
	// Subpalettes
	'subpalettes' => array
	(
		'repetition'            	=> 'period'
	),
    
	// Fields
	'fields' => array
	(
		'toCustomer' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_service']['toCustomer'],
			'inputType'             => 'select',
			'exclude'   			=> true,
			'options_callback'      => array('Customer', 'getCustomerOptions'),
			'eval'                  => array('mandatory'=>true, 'chosen'=>true, 'tl_class'=>'w50','includeBlankOption'=>true, 'submitOnChange'=>true)
		),
        'toProject' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_service']['toProject'],
			'inputType'             => 'select',
			'exclude'   			=> true,
			'options_callback'      => array('Project', 'getProjectsOfCustomer'),
            'eval'                  => array('tl_class'=>'w50', 'chosen'=>true, 'includeBlankOption'=>true)
		),
        'title' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_service']['title'],
			'inputType'             => 'text',
			'exclude'   			=> true,
			'default'               => '-',
			'eval'                  => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50')
		),
        'unit' => array
        (
            'label'                 => &$GLOBALS['TL_LANG']['tl_li_service']['unit'],
            'inputType'             => 'select',
            'exclude'   			=> true,
            'options_callback'      => array('Service', 'getUnitOptions'),
            'eval'                  => array('mandatory'=>true, 'chosen'=>true, 'tl_class'=>'w50')
        ),
        'toServiceType' => array
        (
            'label'                 => &$GLOBALS['TL_LANG']['tl_li_service']['toServiceType'],
            'inputType'             => 'select',
            'exclude'   			=> true,
            'foreignKey'            => 'tl_li_service_type.title',
            'eval'                  => array('mandatory'=>true, 'chosen'=>true, 'tl_class'=>'w50', 'submitOnChange'=>true)
        ),
		'price' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_service']['price'],
			'inputType'             => 'text',
			'exclude'   			=> true,
			'eval'                  => array('mandatory'=>true, 'maxlength'=>12, 'tl_class'=>'w50', 'rgxp'=>'digit', 'alwaysSave'=>true)
		),
        'toTax' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_service']['toTax'],
			'inputType'             => 'select',
			'exclude'   			=> true,
			'options_callback'		=> array('CompanySettings', 'getTaxOptions'),
			'eval'                  => array('mandatory'=>true, 'chosen'=>true, 'tl_class'=>'w50')
		),
        'currency' => array
        (
            'label' 				=> &$GLOBALS['TL_LANG']['tl_li_service']['currency'],
            'inputType' 			=> 'select',
            'exclude' 				=> true,
            'options_callback' 		=> array('CurrencyHelper', 'getCurrencyOptions'),
            'eval' 					=> array('mandatory'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
        ),
        'startDate' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_service']['startDate'],
			'default'               => time(),
			'filter'                => true,
			'sorting'               => true,
			'flag'                  => 8,
			'inputType'             => 'text',
			'exclude'   			=> true,
			'eval'                  => array('rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard')
		),
		'endDate' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_service']['endDate'],
			'default'               => time(),
			'filter'                => true,
			'sorting'               => true,
			'flag'                  => 8,
			'inputType'             => 'text',
			'exclude'   			=> true,
			'eval'                  => array('rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard')
		),
		'repetition' => array
		(
            'label'                 => &$GLOBALS['TL_LANG']['tl_li_service']['repetition'],
			'inputType'             => 'checkbox',
			'exclude'   			=> true,
			'filter'                => true,
			'eval'					=> array('tl_class'=>'clr', 'submitOnChange'=>true)
        ),
		'period' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_service']['period'],
			'inputType'             => 'select',
			'exclude'   			=> true,
			'options'               => array(1,3,6,12),
			'reference'				=> &$GLOBALS['TL_LANG']['tl_li_service']['periods'],
			'eval'                  => array('includeBlankOption'=>true, 'chosen'=>true)
		)
	)
);
