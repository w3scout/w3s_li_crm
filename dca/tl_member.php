<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @author     ApoY2k <apoy2k@gmail.com>
 * @license    MIT (see /LICENSE.txt for further information)
 */
if (!defined('TL_ROOT')) die('You cannot access this file directly!');

// Import tl_style class to use the colorpicker
require_once(dirname(__FILE__).'/../../backend/dca/tl_style.php');

// Modify member dca to add customer fields
$GLOBALS['TL_DCA']['tl_member']['config']['ctable'][]           = 'tl_li_contact';
$GLOBALS['TL_DCA']['tl_member']['palettes']['default']          = "{customer_legend}, isCustomer; ".$GLOBALS['TL_DCA']['tl_member']['palettes']['default'];
$GLOBALS['TL_DCA']['tl_member']['palettes']['__selector__'][]   = 'isCustomer';
$GLOBALS['TL_DCA']['tl_member']['subpalettes']                  = array(
    'login' => 'username,password',
    'assignDir' => 'homeDir',
    'isCustomer' => 'customerNumber,customerName,customerColor');

// Insert adresses support
array_insert($GLOBALS['TL_DCA']['tl_member']['list']['operations'], 5, array(
    'contacts' => array(
        'label' => &$GLOBALS['TL_LANG']['tl_member']['contacts'],
    	'href'  => 'table=tl_li_contact',
    	'icon'  => 'system/modules/li_crm/icons/contacts.png'
    )
));

$GLOBALS['TL_DCA']['tl_member']['fields']['isCustomer'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_member']['isCustomer'],
	'inputType' => 'checkbox',
	'eval'      => array('submitOnChange'=>true)
);

$GLOBALS['TL_DCA']['tl_member']['fields']['customerNumber'] = array
(
	'label'         => &$GLOBALS['TL_LANG']['tl_member']['customerNumber'],
	'search'        => true,
	'sorting'       => true,
	'flag'          => 1,
	'inputType'     => 'text',
	'load_callback' => array(array('Customer', 'createNewCustomerNumber')),
	'eval'          => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50', 'alwaysSave'=>true)
);

$GLOBALS['TL_DCA']['tl_member']['fields']['customerName'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_member']['customerName'],
	'search'    => true,
	'sorting'   => true,
	'flag'      => 1,
	'inputType' => 'text',
	'eval'      => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_member']['fields']['customerColor'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_member']['customerColor'],
	'search'    => true,
	'sorting'   => true,
	'flag'      => 1,
	'inputType' => 'text',
	'eval'      => array('maxlength' => 6, 'isHexColor' => true, 'tl_class' => 'w50 wizard'),
	'wizard'    => array(array('tl_style', 'colorPicker'))
);
