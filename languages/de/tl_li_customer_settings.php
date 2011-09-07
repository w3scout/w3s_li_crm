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
$GLOBALS['TL_LANG']['tl_li_customer_settings']['li_crm_customer_number_generation']       = array('Generierung der Kundennummer', 'Bitte geben Sie die Kombination von Insert-Tags und Text ein, durch die eine Kundennummer generiert werden soll. Mit {{countCustomers::x}} wird die aktuelle Anzahl an Kunden ausgegeben. Der x-Wert bestimmt auf wie viele Stellen die Kundennummer mit Nullen aufgefüllt werden soll.');
$GLOBALS['TL_LANG']['tl_li_customer_settings']['li_crm_customer_number_generation_start'] = array('Kundenzähler Start', 'Bitte geben Sie die Zahl ein, bei der der Kundenzähler startet. Dadurch können Sie die Nummern z. B. ab 100 starten lassen.');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_li_customer_settings']['customer_number_legend'] = 'Kundennummer';

/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_li_customer_settings']['edit']   = 'Kundeneinstellungen bearbeiten';

?>