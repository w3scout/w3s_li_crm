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
$GLOBALS['TL_LANG']['tl_li_invoice']['toCustomer']  = array('Klant', 'Selecteer een klant');
$GLOBALS['TL_LANG']['tl_li_invoice']['toCategory']  = array('Factuurcategorie', 'Selecteer een categorie.');
$GLOBALS['TL_LANG']['tl_li_invoice']['title']       = array('Titel', 'Voer een titel in.');
$GLOBALS['TL_LANG']['tl_li_invoice']['alias']       = array('Referentie', 'Voer een referentie in.');
$GLOBALS['TL_LANG']['tl_li_invoice']['price']       = array('Bedrag', 'Voer het bedrag in.');
$GLOBALS['TL_LANG']['tl_li_invoice']['invoiceDate'] = array('Factuurdatum', 'Voer de factuurdatum in.');
$GLOBALS['TL_LANG']['tl_li_invoice']['file']        = array('Factuur', 'Selecteer ingaande of uitgaande factuur');
$GLOBALS['TL_LANG']['tl_li_invoice']['isOut']       = array('Uitgaande factuur?', 'Is dit een verkoopfactuur?');
$GLOBALS['TL_LANG']['tl_li_invoice']['isSingular']  = array('Eenmalige factuur?', 'Is deze factuur eenmalig?');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_li_invoice']['invoice_legend']  = 'Factuur';
$GLOBALS['TL_LANG']['tl_li_invoice']['pdf_legend']      = 'PDF document';
$GLOBALS['TL_LANG']['tl_li_invoice']['settings_legend'] = 'Instellingen';

/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_li_invoice']['income']         = 'Inkomsten';
$GLOBALS['TL_LANG']['tl_li_invoice']['expense']        = 'Uitgaven';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_li_invoice']['new']    = array('Nieuwe Factuur', 'Maak een nieuwe factuur aan.');
$GLOBALS['TL_LANG']['tl_li_invoice']['edit']   = array('Factuur bewerken', 'Wijzig factuur id %s');
$GLOBALS['TL_LANG']['tl_li_invoice']['copy']   = array('Factuur kopieren', 'Dupliceer factuur id %s');
$GLOBALS['TL_LANG']['tl_li_invoice']['delete'] = array('Verwijder factuur', 'Verwijder factuur %s');
$GLOBALS['TL_LANG']['tl_li_invoice']['show']   = array('Toon details factuur', 'Toon details van factuur id %s');

$GLOBALS['TL_LANG']['tl_li_invoice']['reminder'] = array('Factuur herinnering', 'Beheer de factuurherinnering');
$GLOBALS['TL_LANG']['tl_li_invoice']['new_reminder'] = array('Factuur herinnering', 'Maak nieuwe factuurherinnering');

?>