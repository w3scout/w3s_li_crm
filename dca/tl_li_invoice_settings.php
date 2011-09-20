<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */
$GLOBALS['TL_DCA']['tl_li_invoice_settings'] = array
(
	'config' => array
	(
		'dataContainer' => 'File',
		'closed'        => true
	),
	'palettes' => array
	(
		'default' => '{invoice_number_legend},li_crm_invoice_number_generation,li_crm_invoice_number_generation_start;'.
            '{invoice_currency_legend},li_crm_invoice_standard_currency'
	),
	'fields' => array
	(
		'li_crm_invoice_number_generation' => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_li_invoice_settings']['li_crm_invoice_number_generation'],
			'inputType' => 'text',
			'eval'      => array('tl_class' => 'long', 'mandatory' => true)
		),
		'li_crm_invoice_number_generation_start' => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_li_invoice_settings']['li_crm_invoice_number_generation_start'],
			'inputType' => 'text',
			'eval'      => array('tl_class' => 'clr', 'rgxp' => 'digit', 'mandatory' => true)
		),
        'li_crm_invoice_standard_currency' => array
        (
            'label'             => &$GLOBALS['TL_LANG']['tl_li_invoice_settings']['li_crm_invoice_standard_currency'],
            'inputType'         => 'select',
            'options_callback'  => array('Currency', 'getCurrencyOptions'),
            'eval'              => array('tl_class' => 'w50')
        )
	)
);
