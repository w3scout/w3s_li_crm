<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * PHP version 5
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */

/**
 * Table tl_member
 */


/**
 * Config
 */
$GLOBALS['TL_DCA']['tl_member']['config']['ctable'][] = 'tl_li_contact';
$GLOBALS['TL_DCA']['tl_member']['palettes']['default'] = "{customer_legend},isCustomer;".$GLOBALS['TL_DCA']['tl_member']['palettes']['default'];
$GLOBALS['TL_DCA']['tl_member']['palettes']['__selector__'][] = 'isCustomer';
$GLOBALS['TL_DCA']['tl_member']['subpalettes'] = array('login'=>'username,password','assignDir'=>'homeDir','isCustomer'=>'customerNumber,customerName');

/**
 * Operations
 */
array_insert($GLOBALS['TL_DCA']['tl_member']['list']['operations'], 5, array(
    'contacts' => array(
        'label'               => &$GLOBALS['TL_LANG']['tl_member']['contacts'],
    	'href'                => 'table=tl_li_contact',
    	'icon'                => 'system/modules/li_crm/icons/contacts.png'
    )
));

/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_member']['fields']['isCustomer'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_member']['isCustomer'],
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true)
);

$GLOBALS['TL_DCA']['tl_member']['fields']['customerNumber'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_member']['customerNumber'],
	'search'                  => true,
	'sorting'                 => true,
	'flag'                    => 1,
	'inputType'               => 'text',
	'load_callback'           => array
    (
        array('Customer', 'createNewCustomerNumber')
    ),
	'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50', 'alwaysSave'=>true)
);

$GLOBALS['TL_DCA']['tl_member']['fields']['customerName'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_member']['customerName'],
	'search'                  => true,
	'sorting'                 => true,
	'flag'                    => 1,
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50')
);

?>