<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */

$this->loadLanguageFile('tl_li_invoice_reminder');

$this->import('LiCRM\InvoiceTemplate');
$invoiceTemplate = new LiCRM\InvoiceTemplate();

/**
 * Table tl_li_invoice
 */
$GLOBALS['TL_DCA']['tl_li_invoice'] = array
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
			'fields'                => array('invoiceDate'),
			'panelLayout'           => 'filter;sort,search,limit'
		),
		'label' => array
		(
			'fields'                => array('title'),
			'label_callback'        => array('LiCRM\Invoice', 'renderLabel')
		),
		'global_operations' => array
		(
            'reports' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice']['reports'],
				'href'              => 'key=reports',
				'class'             => 'header_invoice_reports',
				'attributes'        => 'onclick="Backend.getScrollOffset();"'
			),
            'reminder' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice']['reminder'],
				'href'              => 'table=tl_li_invoice_reminder',
				'class'             => 'header_invoice_reminder',
				'attributes'        => 'onclick="Backend.getScrollOffset();"'
			),
            'generation' => array
            (
                'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice']['generation'],
                'href'              => 'table=tl_li_invoice_generation',
                'class'             => 'header_invoice_generation',
                'attributes'        => 'onclick="Backend.getScrollOffset();"'
            ),
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
				'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice']['edit'],
				'href'              => 'act=edit',
				'icon'              => 'edit.gif'
			),
			'copy' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice']['copy'],
				'href'              => 'act=copy',
				'icon'              => 'copy.gif'
			),
			'delete' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice']['delete'],
				'href'              => 'act=delete',
				'icon'              => 'delete.gif',
				'attributes'        => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'toggle' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice']['toggle'],
				'icon'              => 'visible.gif',
				'attributes'        => 'onclick="Backend.getScrollOffset(); return AjaxRequest.toggleVisibility(this, %s);"',
				'button_callback'   => array('LiCRM\Invoice', 'toggleIcon')
			),
			'show' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice']['show'],
				'href'              => 'act=show',
				'icon'              => 'show.gif'
			),
            'togglePaid' => array
            (
                'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice']['togglePaid'],
                'icon'              => 'system/modules/li_crm/assets/invoice_unpaid.png',
                'attributes'        => 'onclick="Backend.getScrollOffset();"',
                'button_callback'   => array('LiCRM\Invoice', 'togglePaidIcon')
            ),
			'showFile' => array
			(
                'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice']['showFile'],
				'icon'              => 'system/modules/li_crm/assets/invoice_show.png',
				'button_callback'   => array('LiCRM\Invoice', 'showFile')
			),
			'downloadFile' => array
			(
                'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice']['downloadFile'],
				'icon'              => 'system/modules/li_crm/assets/invoice_download.png',
				'button_callback'   => array('LiCRM\Invoice', 'downloadFileIcon')
			),
			'html' => array
			(
                'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice']['html'],
				'icon'              => 'system/modules/li_crm/assets/invoice_html_disabled.png',
				'button_callback'   => array('LiCRM\Invoice', 'htmlGenerationIcon')
			),
			'generate' => array
			(
                'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice']['generate'],
				'icon'              => 'system/modules/li_crm/assets/invoice_generation_disabled.png',
				'button_callback'   => array('LiCRM\Invoice', 'generationIcon')
			),
            'send' => array
			(
                'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice']['send'],
				'icon'              => 'system/modules/li_crm/assets/invoice_send_disabled.png',
				'button_callback'   => array('LiCRM\Invoice', 'dispatchIcon')
			),
            'generation' => array
            (
                'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice']['generation'],
                'href'              => 'key=generation',
                'icon'              => 'system/modules/li_crm/assets/generation_new.png'
            ),
			'new_reminder' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['new'],
				'href'              => 'table=tl_li_invoice_reminder&act=create',
				'icon'              => 'system/modules/li_crm/assets/reminder_add.png'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'              => array('enableGeneration'),
		'default'                   => '{invoice_legend},toCustomer,toCategory,title,alias,price,currency,invoiceDate,performanceDate,maturity,paid;
										{pdf_legend},file;
		                                {settings_legend},isOut,isSingular;
		                                {generation_legend},enableGeneration;
		                                {publish_legend},published;'
	),

	// Subpalettes
	'subpalettes' => array
	(
		'enableGeneration'          => 'headline,toTemplate,toAddress,descriptionBefore,servicePositions,productPositions,hourPositions,discount,withoutTaxes,earlyPaymentDiscount,descriptionAfter'
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
            'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice']['toCustomer'],
			'filter'                => true,
			'inputType'             => 'select',
			'exclude'   			=> true,
            'options_callback'      => array('LiCRM\Customer', 'getCustomerOptions'),
			'eval'                  => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50', 'submitOnChange'=>true),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'toCategory' => array
		(
            'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice']['toCategory'],
			'filter'                => true,
			'inputType'             => 'select',
			'exclude'   			=> true,
            'foreignKey'            => 'tl_li_invoice_category.title',
			'eval'                  => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'title' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice']['title'],
			'inputType'             => 'text',
			'exclude'   			=> true,
			'search'                => true,
			'flag'                  => 1,
			'eval'                  => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'alias' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice']['alias'],
			'search'                => true,
			'inputType'             => 'text',
			'exclude'   			=> true,
			'eval'                  => array('rgxp'=>'alnum', 'unique'=>true, 'spaceToUnderscore'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'save_callback' 		=> array
			(
				array('LiCRM\Invoice', 'generateAlias')
			),
            'sql'                     => "varchar(64) NOT NULL default ''"
		),
        'invoiceNumber' => array
        (
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
		'invoiceDate' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice']['invoiceDate'],
			'default'               => time(),
			'flag'                  => 8,
			'inputType'             => 'text',
			'exclude'   			=> true,
			'eval'                  => array('rgxp'=>'date', 'mandatory'=>true, 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
            'sql'                     => "varchar(10) NOT NULL default ''"
		),
		'performanceDate' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice']['performanceDate'],
			'default'               => time(),
			'filter'                => true,
			'sorting'               => true,
			'flag'                  => 8,
			'inputType'             => 'text',
			'exclude'   			=> true,
			'eval'                  => array('rgxp'=>'date', 'mandatory'=>true, 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
            'sql'                     => "varchar(10) NOT NULL default ''"
		),
		'price' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice']['price'],
			'search'                => true,
			'inputType'             => 'text',
			'exclude'   			=> true,
			'eval'                  => array('mandatory'=>true, 'maxlength'=>20, 'tl_class'=>'w50', 'rgxp'=>'digit'),
            'sql'                     => "double unsigned NOT NULL default '0'"
		),
        'currency' => array
        (
            'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice']['currency'],
            'inputType'             => 'select',
            'exclude'               => true,
            'options_callback'      => array('LiCRM\CurrencyHelper', 'getCurrencyOptions'),
            'eval'                  => array('mandatory'=>true, 'chosen'=>true, 'tl_class'=>'w50', 'submitOnChange'=>true),
            'sql'                     => "varchar(3) NOT NULL default ''"
        ),
		'maturity' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice']['maturity'],
			'inputType'             => 'text',
			'exclude'   			=> true,
			'eval'                  => array('tl_class'=>'w50'),
            'sql'                     => "varchar(3) NOT NULL default ''"
		),
        'paid' => array
        (
            'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice']['paid'],
            'inputType'             => 'checkbox',
            'exclude'   			=> true,
            'filter'                => true,
            'eval'                  => array('tl_class'=>'w50 m12'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
		'file' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice']['file'],
			'inputType'             => 'fileTree',
			'exclude'   			=> true,
			'eval'                  => array('fieldType'=>'radio', 'files'=>true, 'tl_class'=>'clr', 'extensions'=>'pdf','path'=>'tl_files'),
            'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'isOut' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice']['isOut'],
			'inputType'             => 'checkbox',
			'exclude'   			=> true,
			'filter'                => true,
			'eval'                  => array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
		),
		'isSingular' => array
		(
            'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice']['isSingular'],
			'inputType'             => 'checkbox',
			'exclude'   			=> true,
			'filter'                => true,
			'eval'                  => array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
		'enableGeneration' => array
		(
            'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice']['enableGeneration'],
			'inputType'             => 'checkbox',
			'exclude'   			=> true,
            'eval'                  => array('submitOnChange'=>true),
            'sql'                   => "char(1) NOT NULL default ''"
        ),
        'headline' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice']['headline'],
			'inputType'             => 'text',
			'exclude'   			=> true,
			'search'                => true,
			'flag'                  => 1,
			'eval'                  => array('maxlength'=>250, 'tl_class'=>'clr'),
            'sql'                     => "varchar(255) NOT NULL default ''"
		),
        'toTemplate' => array
		(
            'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice']['toTemplate'],
			'inputType'             => 'select',
			'exclude'   			=> true,
			'default'				=> $invoiceTemplate->getDefaultTemplate(),
			'foreignKey'      		=> 'tl_li_invoice_template.title',
			'eval'                  => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50', 'mandatory'=>true),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'toAddress' => array
		(
            'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice']['toAddress'],
			'inputType'             => 'select',
			'exclude'   			=> true,
			'options_callback'      => array('LiCRM\Invoice', 'getAddressOptions'),
			'eval'                  => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50', 'mandatory'=>true),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'descriptionBefore' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice']['descriptionBefore'],
            'inputType'             => 'textarea',
            'exclude'   			=> true,
			'eval'                  => array('rte'=>'tinyMCE', 'tl_class'=>'clr'),
            'sql'                     => "text NOT NULL"
		),
        'servicePositions' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice']['servicePositions'],
			'inputType'             => 'multiColumnWizard',
			'exclude'   			=> true,
			'eval'                  => array(
				'columnFields' => array
				(
					'quantity' => array
					(
						'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice']['position_quantity'],
						'exclude'           => true,
						'inputType'         => 'text',
						'eval' 				=> array('style'=>'width:40px;text-align:center;')
					),
					'unit' => array
					(
						'label'  			=> &$GLOBALS['TL_LANG']['tl_li_invoice']['position_unit'],
						'exclude'           => true,
						'inputType'         => 'select',
						'options_callback'	=> array('LiCRM\Invoice', 'getUnitOptions'),
						'eval' 				=> array('style'=>'width:80px;', 'chosen'=>true)
					),
					'item' => array
					(
						'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice']['position_item'],
						'exclude'           => true,
						'inputType'         => 'select',
						'options_callback'  => array('LiCRM\Invoice', 'getServiceOptions'),
						'eval' 				=> array('style'=>'width:160px;', 'chosen'=>true, 'includeBlankOption'=>true)
					),
					'title' => array
					(
						'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice']['position_label'],
						'exclude'           => true,
						'inputType'         => 'text',
						'eval' 				=> array('style'=>'width:290px;')
					)
				)
			),
            'sql'                     => "text NOT NULL"
		),
		'productPositions' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice']['productPositions'],
			'inputType'             => 'multiColumnWizard',
			'exclude'   			=> true,
			'eval'                  => array(
				'columnFields' => array
				(
					'quantity' => array
					(
						'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice']['position_quantity'],
						'exclude'           => true,
						'inputType'         => 'text',
						'eval' 				=> array('style'=>'width:40px;text-align:center;')
					),
					'unit' => array
					(
						'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice']['position_unit'],
						'exclude'           => true,
						'inputType'         => 'select',
						'options_callback' 	=> array('LiCRM\Invoice', 'getUnitOptions'),
						'eval' 				=> array('style'=>'width:80px;', 'chosen'=>true)
					),
					'item' => array
					(
						'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice']['position_item'],
						'exclude'           => true,
						'inputType'         => 'select',
						'options_callback'  => array('LiCRM\Invoice', 'getProductOptions'),
						'eval' 				=> array('style'=>'width:160px;', 'chosen'=>true, 'includeBlankOption'=>true)
					),
					'title' => array
					(
						'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice']['position_label'],
						'exclude'           => true,
						'inputType'         => 'text',
						'eval' 				=> array('style'=>'width:290px;')
					)
				)
			),
            'sql'                     => "text NOT NULL"
		),
		'hourPositions' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice']['hourPositions'],
			'inputType'             => 'multiColumnWizard',
			'exclude'   			=> true,
			'eval'                  => array(
				'columnFields' => array
				(
					'quantity' => array
					(
						'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice']['position_quantity'],
						'exclude'           => true,
						'inputType'         => 'text',
						'eval' 				=> array('style'=>'width:40px;text-align:center;')
					),
					'item' => array
					(
						'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice']['position_item'],
						'exclude'           => true,
						'inputType'         => 'select',
						'options_callback'  => array('LiCRM\Invoice', 'getHourOptions'),
						'eval' 				=> array('style'=>'width:247px;', 'chosen'=>true, 'includeBlankOption'=>true)
					),
					'title' => array
					(
						'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice']['position_label'],
						'exclude'           => true,
						'inputType'         => 'text',
						'eval' 				=> array('style'=>'width:290px;')
					)
				)
			),
            'sql'                     => "text NOT NULL"
		),
        'discount' => array
        (
            'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice']['discount'],
            'inputType'             => 'inputUnit',
            'options'               => array('percent', 'value'),
            'reference'             => &$GLOBALS['TL_LANG']['tl_li_invoice']['discountOptions'],
            'exclude'   			=> true,
            'eval'                  => array('tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'withoutTaxes' => array
        (
            'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice']['withoutTaxes'],
            'inputType'             => 'checkbox',
            'exclude'   			=> true,
            'eval'                  => array('tl_class'=>'w50 m12'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'earlyPaymentDiscount' => array
        (
            'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice']['earlyPaymentDiscount'],
            'inputType'             => 'text',
            'exclude'   			=> true,
            'eval'                  => array('tl_class'=>'long clr'),
            'sql'                     => "text NOT NULL"
        ),
        'descriptionAfter' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice']['descriptionAfter'],
            'inputType'             => 'textarea',
            'exclude'   			=> true,
			'eval'                  => array('rte'=>'tinyMCE', 'tl_class'=>'clr'),
            'sql'                     => "text NOT NULL"
		),
		'published' => array
		(
            'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice']['published'],
			'inputType'             => 'checkbox',
			'exclude'   			=> true,
			'filter'                => true,
            'sql'                     => "char(1) NOT NULL default ''"
        )
	)
);