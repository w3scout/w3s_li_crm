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
$GLOBALS['TL_DCA']['tl_li_task_reminder_settings'] = array
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
		'default'                     => '{message_legend},li_crm_task_reminder_from,li_crm_task_reminder_fromName;'
	),

	// Subpalettes
	'subpalettes' => array
	(
		''                     => ''
	),

	// Fields
	'fields' => array
	(
		'li_crm_task_reminder_from' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_task_reminder_settings']['li_crm_task_reminder_from'],
			'inputType'               => 'text',
			'search'                  => true,
			'eval'                    => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50')
		),
		'li_crm_task_reminder_fromName' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_task_reminder_settings']['li_crm_task_reminder_fromName'],
			'inputType'               => 'text',
			'search'                  => true,
			'eval'                    => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50')
		)
	)
);