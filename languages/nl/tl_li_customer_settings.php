<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * PHP version 5
 * @copyright  Artified 2011
 * @author     Paul Kegel <info@artified.nl>
 * @license    MIT (see /LICENSE.txt for further information)
 */

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_li_customer_settings']['li_crm_customer_number_generation']       = array('Generatie klantnummer', 'Voer een combinatie van insert tags en tekst hoe het klantnummer wordt gegenereerd. Er kan gebruik worden gemaakt van {{countCustomers::x}} voor het verkrijgen van klantnummers. De waarde van x stelt in hoe veel cijfers worden gebruikt, de rest wordt opgevult met nullen.');
$GLOBALS['TL_LANG']['tl_li_customer_settings']['li_crm_customer_number_generation_start'] = array('Klantenteller startgetal', 'Voer een getal in waarmee het klantnummer begint. Hierdoor kan bijvoorbeeld het klantnummer beginnen met 100.');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_li_customer_settings']['customer_number_legend'] = 'Klantnummer';

/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_li_customer_settings']['edit']   = 'Wijzig klantinstellingen';

?>