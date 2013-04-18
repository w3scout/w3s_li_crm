<?php

/**
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */

/**
 * Settings - Invoice reminder settings
 */
$GLOBALS['TL_DCA']['tl_li_invoice_reminder_settings'] = array
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
		'default'                   => '{message_legend},li_crm_invoice_reminder_from,li_crm_invoice_reminder_fromName,li_crm_invoice_reminder_receiver;'
	),

	// Fields
	'fields' => array
	(
		'li_crm_invoice_reminder_from' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice_reminder_settings']['li_crm_invoice_reminder_from'],
			'inputType'             => 'text',
			'exclude'   			=> true,
			'search'                => true,
			'eval'                  => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50')
		),
		'li_crm_invoice_reminder_fromName' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice_reminder_settings']['li_crm_invoice_reminder_fromName'],
			'inputType'             => 'text',
			'exclude'   			=> true,
			'search'                => true,
			'eval'                  => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50')
		),
        'li_crm_invoice_reminder_receiver' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_invoice_reminder_settings']['li_crm_invoice_reminder_receiver'],
			'inputType'             => 'checkboxWizard',
			'exclude'   			=> true,
			'foreignKey'            => 'tl_user.username',
			'eval'                  => array('mandatory'=>true, 'multiple'=>true, 'tl_class'=>'clr')
		)
	)
);
