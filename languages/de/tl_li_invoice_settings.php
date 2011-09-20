<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */
$GLOBALS['TL_LANG']['tl_li_invoice_settings']['invoice_number_legend'] = 'Rechnungsnummer';
$GLOBALS['TL_LANG']['tl_li_invoice_settings']['invoice_currency_legend'] = 'Währungen';

$GLOBALS['TL_LANG']['tl_li_invoice_settings']['li_crm_invoice_number_generation'] = array('Generierung der Rechnungsnummer', 'Bitte geben Sie die Kombination von Insert-Tags und Text ein, durch die eine Rechnungsnummer generiert werden soll. Mit {{countInvoices::x}} wird die aktuelle Anzahl der Ausgangsrechnungen ausgegeben. Der x-Wert bestimmt auf wie viele Stellen die Rechnungsnummer mit Nullen aufgefüllt werden soll.');
$GLOBALS['TL_LANG']['tl_li_invoice_settings']['li_crm_invoice_number_generation_start'] = array('Rechnungsnummer Start', 'Bitte geben Sie die Zahl ein, bei der der Rechnungszähler startet. Dadurch können Sie die Nummern z. B. ab 100 starten lassen.');

$GLOBALS['TL_LANG']['tl_li_invoice_settings']['li_crm_invoice_standard_currency'] = array('Standardwährung', 'Diese Währung wird standardmäßig in Rechnungen verwendet, wenn diese keine eigene Angaben zur Währung machen.');

$GLOBALS['TL_LANG']['tl_li_invoice_settings']['edit'] = 'Rechnungseinstellungen bearbeiten';