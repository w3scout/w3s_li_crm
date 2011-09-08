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
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['toCustomer']       = array('Klant', 'Selecteer een klant.');
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['toInvoice']        = array('Factuur', 'Selecteer een factuur.');
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['remindOnce']       = array('Herinner eenmalig', 'Moet deze herinnering eenmalig verzonden worden?');
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['remindDate']       = array('Herinnerings datum', 'Voer de datum in dat de herinnering moet worden verzonden.');
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['remindRepeatedly'] = array('Herinnering herhalen', 'Moet de herinnering worden herhaald?');
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['remindInterval']   = array('Interval', 'Selecteer interval');

/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['reminder_legend']   = 'Herinnering';
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['once_legend']       = 'Eenmalig';
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['repeatedly_legend'] = 'Meerdere malen';

/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['noCustomer']                = 'Geen klant';
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['remindInterval']['daily']   = 'Dagelijks';
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['remindInterval']['weekly']  = 'Weekelijks';
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['remindInterval']['monthly'] = 'Maandelijks';
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['remindInterval']['yearly']  = 'Jaarlijks';
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['subject']                   = 'Factuur herinnering';
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['text']                      = 'Factuur herinnering voor factuur "%s" van %s.';
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['customerRemark']            = 'Deze factuur hoort bij klant "%s %s".';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['new']    = array('Nieuwe Herinnering', 'Maak een herinnering');
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['edit']   = array('Herinnering bewerken', 'Wijzig herinnering ID %s');
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['copy']   = array('Herinnering kopieren', 'Dupliceer herinnering ID %s');
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['delete'] = array('Herinnering verwijderen', 'Verwijder herinnering ID %s');
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['show']   = array('Toon details herinnering', 'Toon details van herinnering ID %s');

?>