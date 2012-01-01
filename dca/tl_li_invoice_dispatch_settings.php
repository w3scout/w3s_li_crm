<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * PHP version 5
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */

/**
 * Customer settings
 */
$GLOBALS['TL_DCA']['tl_li_invoice_dispatch_settings'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'File',
		'closed'                      => true
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array(),
		'default'                     => '{dispatch_legend},li_crm_invoice_dispatch_from,li_crm_invoice_dispatch_fromName;'
	),

	// Subpalettes
	'subpalettes' => array
	(
		''                     => ''
	),

	// Fields
	'fields' => array
	(
		'li_crm_invoice_dispatch_from' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice_dispatch_settings']['li_crm_invoice_dispatch_from'],
			'inputType'               => 'text',
			'exclude'   			  => true,
			'search'                  => true,
			'eval'                    => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50')
		),
		'li_crm_invoice_dispatch_fromName' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_invoice_dispatch_settings']['li_crm_invoice_dispatch_fromName'],
			'inputType'               => 'text',
			'exclude'   			  => true,
			'search'                  => true,
			'eval'                    => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50')
		)
	)
);