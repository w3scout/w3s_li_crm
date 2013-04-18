<?php

/**
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */

/**
 * Settings - Dispatch settings
 */
$GLOBALS['TL_DCA']['tl_li_invoice_dispatch_settings'] = array
(
	// Config
	'config' => array
	(
		'dataContainer'             => 'File',
		'closed'                    => true
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'              => array(),
		'default'                   => '{dispatch_legend},li_crm_invoice_dispatch_from,li_crm_invoice_dispatch_fromName;'
	),

	// Fields
	'fields' => array
	(
		'li_crm_invoice_dispatch_from' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice_dispatch_settings']['li_crm_invoice_dispatch_from'],
			'inputType'             => 'text',
			'exclude'   			=> true,
			'search'                => true,
			'eval'                  => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50')
		),
		'li_crm_invoice_dispatch_fromName' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice_dispatch_settings']['li_crm_invoice_dispatch_fromName'],
			'inputType'             => 'text',
			'exclude'   			=> true,
			'search'                => true,
			'eval'                  => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50')
		)
	)
);
