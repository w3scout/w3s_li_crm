<?php

/**
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */

/**
 * Settings - Invoice settings
 */
$GLOBALS['TL_DCA']['tl_li_invoice_settings'] = array
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
        'default'                   => '{invoice_data_legend},li_crm_invoice_maturity;{invoice_number_legend},li_crm_invoice_number_generation, li_crm_invoice_number_generation_start;'
	),

	// Fields
	'fields' => array
	(
		'li_crm_invoice_maturity' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice_settings']['li_crm_invoice_maturity'],
			'inputType'             => 'text',
			'exclude'   			=> true,
			'eval'                  => array('tl_class'=>'w50', 'mandatory'=>true)
		),
		'li_crm_invoice_number_generation' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice_settings']['li_crm_invoice_number_generation'],
			'inputType'             => 'text',
			'exclude'   			=> true,
			'eval'                  => array('tl_class'=>'long', 'mandatory'=>true)
		),
		'li_crm_invoice_number_generation_start' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice_settings']['li_crm_invoice_number_generation_start'],
			'inputType'             => 'text',
			'exclude'   			=> true,
			'eval'                  => array('tl_class'=>'clr', 'rgxp'=>'digit', 'mandatory'=>true)
		)
	)
);
