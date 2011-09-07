<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * PHP version 5
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */

/**
 * Project settings
 */
$GLOBALS['TL_DCA']['tl_li_project_settings'] = array
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
		'default'                     => '{project_number_legend},li_crm_project_number_generation, li_crm_project_number_generation_start;'
	),

	// Fields
	'fields' => array
	(
		'li_crm_project_number_generation' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_project_settings']['li_crm_project_number_generation'],
			'inputType'               => 'text',
			'eval'                    => array('tl_class'=>'long')
		),
		'li_crm_project_number_generation_start' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_project_settings']['li_crm_project_number_generation_start'],
			'inputType'               => 'text',
			'eval'                    => array('tl_class'=>'clr', 'rgxp'=>'digit')
		)
	)
);