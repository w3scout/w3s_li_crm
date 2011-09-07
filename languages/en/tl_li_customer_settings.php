<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * PHP version 5
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_li_customer_settings']['li_crm_customer_number_generation']       = array('Customer number generation', 'Please enter a combination of insert tags and text through which the customer number will be generated. You can use {{countCustomers::x}} to get the current number of customers. The x-Value defines on how many marks will be used. The rest will be filled with zeros.');
$GLOBALS['TL_LANG']['tl_li_customer_settings']['li_crm_customer_number_generation_start'] = array('Customer counter start', 'Please enter a number at which the customer counter starts. Through this you\'re able to, for example, let the number start at 100.');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_li_customer_settings']['customer_number_legend'] = 'Customer number';

/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_li_customer_settings']['edit']   = 'Edit customer settings';

?>