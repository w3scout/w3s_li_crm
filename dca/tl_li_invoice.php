<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * PHP version 5
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */

/**
 * Table tl_li_invoice
 */
$this->loadLanguageFile('tl_li_invoice_reminder');
$GLOBALS['TL_DCA']['tl_li_invoice'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => true,
		'onsubmit_callback' => array
		(
			array('Invoice', 'savePositionsField')
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('invoiceDate'),
			'panelLayout'             => 'filter;sort,search,limit'
		),
		'label' => array
		(
			'fields'                  => array('title'),
			'label_callback'          => array('Invoice', 'renderLabel')
		),
		'global_operations' => array
		(
            'reports' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_invoice']['reports'],
				'href'                => 'key=reports',
				'class'               => 'header_invoice_reports',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			),
            'reminder' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_invoice']['reminder'],
				'href'                => 'table=tl_li_invoice_reminder',
				'class'               => 'header_invoice_reminder',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			),
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
				'label'               => &$GLOBALS['TL_LANG']['tl_li_invoice']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_invoice']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_invoice']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_invoice']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			),
			'showFile' => array
			(
                'label'               => &$GLOBALS['TL_LANG']['tl_li_invoice']['showFile'],
				'icon'                => 'system/modules/li_crm/icons/invoice_show.png',
				'button_callback'     => array('Invoice', 'showFile')
			),
			'downloadFile' => array
			(
                'label'               => &$GLOBALS['TL_LANG']['tl_li_invoice']['downloadFile'],
				'icon'                => 'system/modules/li_crm/icons/invoice_download.png',
				'button_callback'     => array('Invoice', 'downloadFile')
			),
			'generate' => array
			(
                'label'               => &$GLOBALS['TL_LANG']['tl_li_invoice']['generate'],
				'icon'                => 'system/modules/li_crm/icons/invoice_generation_disabled.png',
				'button_callback'     => array('Invoice', 'generationIcon')
			),
            'send' => array
			(
                'label'               => &$GLOBALS['TL_LANG']['tl_li_invoice']['send'],
				'icon'                => 'system/modules/li_crm/icons/invoice_send_disabled.png',
				'button_callback'     => array('Invoice', 'dispatchIcon')
			),
			'new_reminder' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['new'],
				'href'                => 'table=tl_li_invoice_reminder&act=create',
				'icon'                => 'system/modules/li_crm/icons/reminder_add.png'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array('enableGeneration'),
		'default'                     => '{invoice_legend},toCustomer,toCategory,title,alias,price,maturity,invoiceDate,performanceDate;{pdf_legend},file;{settings_legend},isOut,isSingular;{generation_legend},enableGeneration;'
	),

	// Subpalettes
	'subpalettes' => array
	(
		'enableGeneration'            => 'headline,toTemplate,toAddress,descriptionBefore,positions,positions_new,descriptionAfter'
	),

	// Fields
	'fields' => array
	(
        'toCustomer' => array
		(
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice']['toCustomer'],
			'filter'                  => true,
			'inputType'               => 'select',
			'exclude'   			  => true,
            'options_callback'        => array('Customer', 'getCustomerOptions'),
			'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50', 'submitOnChange'=>true)
        ),
        'toCategory' => array
		(
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice']['toCategory'],
			'filter'                  => true,
			'inputType'               => 'select',
			'exclude'   			  => true,
            'foreignKey'              => 'tl_li_invoice_category.title',
			'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50')
        ),
        'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice']['title'],
			'inputType'               => 'text',
			'exclude'   			  => true,
			'search'                  => true,
			'flag'                    => 1,
			'eval'                    => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50')
		),
		'alias' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice']['alias'],
			'search'                  => true,
			'inputType'               => 'text',
			'exclude'   			  => true,
			'eval'                    => array('rgxp'=>'alnum', 'unique'=>true, 'spaceToUnderscore'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('Invoice', 'generateAlias')
			)
		),
		'invoiceDate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice']['invoiceDate'],
			'default'                 => time(),
			'flag'                    => 8,
			'inputType'               => 'text',
			'exclude'   			  => true,
			'eval'                    => array('rgxp'=>'date', 'mandatory'=>true, 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard')
		),
		'performanceDate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice']['performanceDate'],
			'default'                 => time(),
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 8,
			'inputType'               => 'text',
			'exclude'   			  => true,
			'eval'                    => array('rgxp'=>'date', 'mandatory'=>true, 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard')
		),
		'price' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice']['price'],
			'search'                  => true,
			'inputType'               => 'text',
			'exclude'   			  => true,
			'eval'                    => array('mandatory'=>true, 'maxlength'=>20, 'tl_class'=>'w50', 'rgxp'=>'digit')
		),
		'maturity' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice']['maturity'],
			'inputType'               => 'text',
			'exclude'   			  => true,
			'eval'                    => array('tl_class'=>'w50')
		),
		'file' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice']['file'],
			'inputType'               => 'fileTree',
			'exclude'   			  => true,
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'tl_class'=>'clr', 'extensions'=>'pdf','path'=>'tl_files')
		),
		'isOut' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice']['isOut'],
			'inputType'               => 'checkbox',
			'exclude'   			  => true,
			'filter'                  => true,
			'eval'                    => array('tl_class'=>'w50')
		),
		'isSingular' => array
		(
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice']['isSingular'],
			'inputType'               => 'checkbox',
			'exclude'   			  => true,
			'filter'                  => true,
			'eval'                    => array('tl_class'=>'w50')
        ),
		'enableGeneration' => array
		(
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice']['enableGeneration'],
			'inputType'               => 'checkbox',
			'exclude'   			  => true,
			'filter'                  => true,
            'eval'                    => array('submitOnChange'=>true)
        ),
        'headline' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice']['headline'],
			'inputType'               => 'text',
			'exclude'   			  => true,
			'search'                  => true,
			'flag'                    => 1,
			'eval'                    => array('maxlength'=>250, 'tl_class'=>'clr')
		),
        'toTemplate' => array
		(
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice']['toTemplate'],
			'inputType'               => 'select',
			'exclude'   			  => true,
			'foreignKey'              => 'tl_li_invoice_template.title',
			'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50', 'mandatory'=>true)
        ),
        'toAddress' => array
		(
            'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice']['toAddress'],
			'inputType'               => 'select',
			'exclude'   			  => true,
			'options_callback'        => array('Invoice', 'getAddressOptions'),
			'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50', 'mandatory'=>true)
        ),
        'descriptionBefore' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice']['descriptionBefore'],
            'inputType'               => 'textarea',
            'exclude'   			  => true,
			'eval'                    => array('rte'=>'tinyMCE', 'tl_class'=>'clr')
		),
        'positions' => array
        (
            'input_field_callback'    => array('Invoice', 'positionsField')
            
        ),
        'positions_new' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_company_settings']['positions_new'],
			'inputType'               => 'multiColumnWizard',
			'exclude'   			  => true,
			'eval'                    => array(
				'columnFields' => array
				(
					'amount' => array
					(
						'label'                 => &$GLOBALS['TL_LANG']['tl_theme']['ts_client_browser'],
						'exclude'               => true,
						'inputType'             => 'text',
						'eval' 			=> array('style'=>'width:30px')
					),
					'unit' => array
					(
						'label'                 => &$GLOBALS['TL_LANG']['tl_theme']['ts_client_os'],
						'exclude'               => true,
						'inputType'             => 'select',
						'options_callback' 		=> array('Invoice', 'getUnitOptions'),
						'eval' 			=> array('style' => 'width:70px')
					),
					'offer' => array
					(
						'label'                 => &$GLOBALS['TL_LANG']['tl_theme']['ts_client_browser'],
						'exclude'               => true,
						'inputType'             => 'select',
						'options_callback'      => array('Invoice', 'getOfferOptions'),
						'eval' 			=> array('style'=>'width:100px', 'includeBlankOption'=>true)
					),
					'title' => array
					(
						'label'                 => &$GLOBALS['TL_LANG']['tl_theme']['ts_client_browser'],
						'exclude'               => true,
						'inputType'             => 'text',
						'eval' 			=> array('style'=>'width:180px')
					),
					'tax' => array
					(
						'label'                 => &$GLOBALS['TL_LANG']['tl_theme']['ts_client_mobile'],
						'exclude'               => true,
						'inputType'             => 'select',
						'options'				=> array('7'=>'7%', '19'=>'19%'),
						'eval'                  => array('style'=>'width:50px')
		 
					),
					'price' => array
					(
						'label' 		=> &$GLOBALS['TL_LANG']['tl_theme']['ts_extension'],
						'inputType' 		=> 'text',
						'eval'                  => array('mandatory'=>true, 'style'=>'width:50px')
					),
				)
			)
		),
        'descriptionAfter' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice']['descriptionAfter'],
            'inputType'               => 'textarea',
            'exclude'   			  => true,
			'eval'                    => array('rte'=>'tinyMCE', 'tl_class'=>'clr')
		)
	)
);

?>