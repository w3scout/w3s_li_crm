<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */

 /**
 * Table tl_li_invoice_reminder
 */
$GLOBALS['TL_DCA']['tl_li_invoice_reminder'] = array
(
	// Config
	'config' => array
	(
		'dataContainer'             => 'Table',
		'enableVersioning'  		=> true,
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
			'mode'          		=> 1,
			'fields'        		=> array('toCustomer'),
			'flag'          		=> 1,
			'panelLayout'   		=> 'filter;sort,limit'
		),
		'label' => array
		(
			'fields'           		=> array('toCustomer', 'toInvoice'),
			'format'				=> '%s %s',
			'label_callback'    	=> array('LiCRM\InvoiceReminder', 'renderLabel'),
		),
		'global_operations' => array
		(
            'all' => array
			(
				'label'         	=> &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'          	=> 'act=select',
				'class'         	=> 'header_edit_all',
				'attributes'    	=> 'onclick="Backend.getScrollOffset();"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label' 			=> &$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['edit'],
				'href'  			=> 'act=edit',
				'icon'  			=> 'edit.gif'
			),
			'copy' => array
			(
				'label' 			=> &$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['copy'],
				'href'  			=> 'act=copy',
				'icon'  			=> 'copy.gif'
			),
			'delete' => array
			(
				'label'         	=> &$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['delete'],
				'href'          	=> 'act=delete',
				'icon'          	=> 'delete.gif',
				'attributes'    	=> 'onclick="if (!confirm(\''.$GLOBALS['TL_LANG']['MSC']['deleteConfirm'].'\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label' 			=> &$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['show'],
				'href'  			=> 'act=show',
				'icon'  			=> 'show.gif'
			)
		)
	),
	
	// Palettes
	'palettes' => array
	(
		'__selector__'  			=> array('remindOnce', 'remindRepeatedly'),
		'default'       			=> '{reminder_legend}, toCustomer, toInvoice;
										{once_legend},remindOnce;
										{repeatedly_legend},remindRepeatedly;'
	),
	
	// Subpalettes
	'subpalettes' => array
	(
		'remindOnce'        		=> 'remindDate',
		'remindRepeatedly'  		=> 'remindInterval'
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
            'label'             	=> &$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['toCustomer'],
			'filter'            	=> true,
			'inputType'         	=> 'select',
			'exclude'   			=> true,
            'options_callback'  	=> array('LiCRM\InvoiceReminder', 'getCustomerOptions'),
			'eval'              	=> array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50', 'submitOnChange'=>true),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'toInvoice' => array
		(
            'label'             	=> &$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['toInvoice'],
			'inputType'         	=> 'select',
			'exclude'   			=> true,
            'options_callback'  	=> array('LiCRM\InvoiceReminder', 'getInvoiceOptions'),
			'eval'              	=> array('tl_class'=>'w50', 'mandatory'=>true, 'chosen'=>true, 'submitOnChange'=>true, 'includeBlankOption'=>true),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'remindOnce' => array
		(
            'label'             	=> &$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['remindOnce'],
			'inputType'         	=> 'checkbox',
			'exclude'           	=> true,
			'filter'            	=> true,
			'eval'              	=> array('submitOnChange'=>true),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'remindDate' => array
		(
			'label'             	=> &$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['remindDate'],
			'default'           	=> time(),
			'filter'            	=> true,
			'sorting'           	=> true,
			'flag'              	=> 8,
			'inputType'         	=> 'text',
			'exclude'   	    	=> true,
			'load_callback'     	=> array(array('LiCRM\InvoiceReminder', 'getRemindDate')),
			'eval'              	=> array('rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
            'sql'                     => "varchar(10) NOT NULL default ''"
		),
        'remindRepeatedly' => array
		(
            'label'             	=> &$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['remindRepeatedly'],
			'inputType'         	=> 'checkbox',
			'exclude'           	=> true,
			'filter'            	=> true,
			'eval'              	=> array('submitOnChange'=>true),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'remindInterval' => array
		(
            'label'             	=> &$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['remindInterval'],
			'filter'            	=> true,
			'inputType'         	=> 'select',
			'exclude'           	=> true,
            'options'           	=> array('daily', 'weekly', 'monthly', 'yearly'),
            'reference'         	=> &$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['remindInterval'],
			'eval'              	=> array('tl_class'=>'w50', 'chosen'=>true),
            'sql'                     => "varchar(20) NOT NULL default ''"
        )
	)
);
