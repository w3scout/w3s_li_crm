<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     apoy2k
 * @license    MIT (see /LICENSE.txt for further information)
 */
$GLOBALS['TL_DCA']['tl_li_product_to_project'] = array
(
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => false
	),

	'palettes' => array
	(
		'__selector__'                => array(''),
		'default'                     => '{legend}, toCustomer, toProject, toProduct;'
	),

	'subpalettes' => array
	(
		''                            => ''
	),

	'fields' => array
	(
        'toProject' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_product_to_project']['toProject'],
			'inputType'               => 'select',
			'eval'                    => array('mandatory' => true, 'tl_class' => 'w50', 'includeBlankOption' => true),
			'options_callback'        => array('Project', 'getProjectsByCustomerList')
		),
		'toProduct' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_li_product_to_project']['toProduct'],
			'inputType'               => 'select',
			'eval'                    => array('mandatory' => true, 'tl_class' => 'w50', 'includeBlankOption' => true),
			'options_callback'        => array('Product', 'getProductsList')
		)
	)
);
