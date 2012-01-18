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
	'exclude'   => true,
	'eval'      => array('submitOnChange'=>true)
);

$GLOBALS['TL_DCA']['tl_member']['fields']['customerNumber'] = array
(
	'label'         => &$GLOBALS['TL_LANG']['tl_member']['customerNumber'],
	'search'        => true,
	'sorting'       => true,
	'flag'          => 1,
	'inputType'     => 'text',
	'exclude'   	=> true,
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
	'exclude'   => true,
	'eval'      => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_member']['fields']['customerColor'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_member']['customerColor'],
	'search'    => true,
	'sorting'   => true,
	'flag'      => 1,
	'inputType' => 'text',
	'exclude'   => true,
	'eval'      => array('maxlength' => 6, 'isHexColor' => true, 'tl_class' => 'w50')
);
