<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @author     ApoY2k <apoy2k@gmail.com>
 * @license    MIT (see /LICENSE.txt for further information)
 */

/**
 * Table tl_member
 */

// Modify member dca to add customer fields
$GLOBALS['TL_DCA']['tl_member']['config']['ctable'][]            = 'tl_li_contact';
//$GLOBALS['TL_DCA']['tl_member']['config']['onload_callback'][]   = array('Customer', 'changeMandatoryFields');
$GLOBALS['TL_DCA']['tl_member']['config']['onsubmit_callback'][] = array('Customer', 'updateDefaultAddress');
$GLOBALS['TL_DCA']['tl_member']['palettes']['default']           = "{customer_legend}, isCustomer;"
                                                                   .$GLOBALS['TL_DCA']['tl_member']['palettes']['default']."
                                                                   ;{bank_legend},accountNumber,bankCode,bank,iban,bic";
$GLOBALS['TL_DCA']['tl_member']['palettes']['__selector__'][]    = 'isCustomer';
$GLOBALS['TL_DCA']['tl_member']['subpalettes']                   = array(
    'login'                 => 'username,password',
    'assignDir'             => 'homeDir',
    'isCustomer'            => 'customerNumber,customerName,customerColor'
);

// Insert adresses support
array_insert($GLOBALS['TL_DCA']['tl_member']['list']['operations'], 5, array
(
    'contacts' => array
    (
        'label'             => &$GLOBALS['TL_LANG']['tl_member']['contacts'],
    	'href'              => 'table=tl_li_contact',
    	'icon'              => 'system/modules/li_crm/icons/contacts.png'
    )
));

$GLOBALS['TL_DCA']['tl_member']['fields']['isCustomer'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_member']['isCustomer'],
	'inputType'             => 'checkbox',
	'exclude'               => true,
	'eval'                  => array('submitOnChange'=>true),
    'sql'                     => "char(1) NOT NULL default ''"

);

$GLOBALS['TL_DCA']['tl_member']['fields']['customerNumber'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_member']['customerNumber'],
	'search'                => true,
	'sorting'               => true,
	'flag'                  => 1,
	'inputType'             => 'text',
	'exclude'   	        => true,
	'load_callback'         => array(array('Customer', 'createNewCustomerNumber')),
	'eval'                  => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50', 'alwaysSave'=>true),
    'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_member']['fields']['customerName'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_member']['customerName'],
	'search'                => true,
	'sorting'               => true,
	'flag'                  => 1,
	'inputType'             => 'text',
	'exclude'               => true,
	'eval'                  => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_member']['fields']['customerColor'] = array
(
    'label'                 => &$GLOBALS['TL_LANG']['tl_member']['customerColor'],
	'search'                => true,
	'sorting'               => true,
	'flag'                  => 1,
	'inputType'             => 'text',
	'exclude'               => true,
	'eval'                  => array('maxlength'=>6, 'isHexColor'=>true, 'tl_class'=>'w50'),
    'sql'                     => "varchar(6) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_member']['fields']['accountNumber'] = array
(
    'label'                 => &$GLOBALS['TL_LANG']['tl_member']['accountNumber'],
    'inputType'             => 'text',
    'exclude'   			=> true,
    'eval'                  => array('maxlength'=>64, 'rgxp'=>'digit', 'feEditable'=>true, 'feViewable'=>true, 'feGroup'=>'bank'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_member']['fields']['bankCode'] = array
(
    'label'                 => &$GLOBALS['TL_LANG']['tl_member']['bankCode'],
    'inputType'             => 'text',
    'exclude'   			=> true,
    'eval'                  => array('maxlength'=>64, 'rgxp'=>'digit', 'tl_class'=>'w50', 'feEditable'=>true, 'feViewable'=>true, 'feGroup'=>'bank'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_member']['fields']['bank'] = array
(
    'label'                 => &$GLOBALS['TL_LANG']['tl_member']['bank'],
    'inputType'             => 'text',
    'exclude'   			=> true,
    'eval'                  => array('maxlength'=>100, 'tl_class'=>'w50', 'feEditable'=>true, 'feViewable'=>true, 'feGroup'=>'bank'),
    'sql'                     => "varchar(100) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_member']['fields']['iban'] = array
(
    'label'                 => &$GLOBALS['TL_LANG']['tl_member']['iban'],
    'inputType'             => 'text',
    'exclude'   			=> true,
    'eval'                  => array('maxlength'=>64, 'tl_class'=>'w50', 'feEditable'=>true, 'feViewable'=>true, 'feGroup'=>'bank'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_member']['fields']['bic'] = array
(
    'label'                 => &$GLOBALS['TL_LANG']['tl_member']['bic'],
    'inputType'             => 'text',
    'exclude'   			=> true,
    'eval'                  => array('maxlength'=>64, 'tl_class'=>'w50', 'feEditable'=>true, 'feViewable'=>true, 'feGroup'=>'bank'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_member']['fields']['registerProducts'] = array
(
	'label'         		=> &$GLOBALS['TL_LANG']['tl_member']['registerProducts'],
	'exclude'       		=> true,
	'inputType'     		=> 'checkbox',
	'foreignKey'    		=> 'tl_li_product.title',
	'eval'          		=> array('multiple'=>true, 'feEditable'=>true, 'feViewable'=>true, 'feGroup'=>'bank'),
    'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_member']['fields']['registerProduct'] = array
(
	'label'         		=> &$GLOBALS['TL_LANG']['tl_member']['registerProduct'],
	'exclude'       		=> true,
	'inputType'     		=> 'select',
	'foreignKey'    		=> 'tl_li_product.title',
	'eval'          		=> array('feEditable'=>true, 'feViewable'=>true, 'feGroup'=>'bank'),
    'sql'                     => "int(10) unsigned NOT NULL default '0'"
);
