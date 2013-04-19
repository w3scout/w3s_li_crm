<?php if (!defined('TL_ROOT')) die("You cannot access this file directly!");

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */

$GLOBALS['TL_LANG']['tl_li_customer_settings']['edit']                                          = "Kundeneinstellungen bearbeiten";

$GLOBALS['TL_LANG']['tl_li_customer_settings']['customer_number_legend']                        = "Kundennummer";

$GLOBALS['TL_LANG']['tl_li_customer_settings']['li_crm_customer_number_generation'][0]          = "Generierung der Kundennummer";
$GLOBALS['TL_LANG']['tl_li_customer_settings']['li_crm_customer_number_generation'][1]          = "Bitte geben Sie die Kombination von Insert-Tags und Text ein, durch die eine Kundennummer generiert werden soll. Mit {{countCustomers::x}} wird die aktuelle Anzahl an Kunden ausgegeben. Der x-Wert bestimmt auf wie viele Stellen die Kundennummer mit Nullen aufgefüllt werden soll.";

$GLOBALS['TL_LANG']['tl_li_customer_settings']['li_crm_customer_number_generation_start'][0]    = "Kundenzähler Start";
$GLOBALS['TL_LANG']['tl_li_customer_settings']['li_crm_customer_number_generation_start'][1]    = "Bitte geben Sie die Zahl ein, bei der der Kundenzähler startet. Dadurch können Sie die Nummern z. B. ab 100 starten lassen.";
