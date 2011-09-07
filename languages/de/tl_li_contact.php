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
$GLOBALS['TL_LANG']['tl_li_contact']['title']         = array('Titel', 'Bitte geben Sie den Titel ein.');
$GLOBALS['TL_LANG']['tl_li_contact']['category']      = array('Kategorie', 'Bitte wählen Sie die Kategorie aus.');
$GLOBALS['TL_LANG']['tl_li_contact']['startDate']     = array('Startdatum', 'Bitte geben Sie das Startdatum gemäß des globalen Datumsformats ein.');
$GLOBALS['TL_LANG']['tl_li_contact']['startTime']     = array('Startzeit', 'Bitte geben Sie die Startzeit gemäß des globalen Zeitformats ein.');
$GLOBALS['TL_LANG']['tl_li_contact']['addEnd']        = array('Ende hinzufügen', 'Dem Kontakt Enddatum und -zeit hinzufügen.');
$GLOBALS['TL_LANG']['tl_li_contact']['endDate']       = array('Enddatum', 'Lassen Sie das Feld leer, um ein eintägiges Event zu erstellen.');
$GLOBALS['TL_LANG']['tl_li_contact']['endTime']       = array('Endzeit', 'Geben Sie dieselbe Start- und Endzeit ein, um ein Event mit offenem Ende zu erstellen.');
$GLOBALS['TL_LANG']['tl_li_contact']['result']        = array('Ergebnis', 'Bitte wählen Sie das Ergebnis aus.');
$GLOBALS['TL_LANG']['tl_li_contact']['direction']     = array('Richtung', 'Bitte wählen Sie die Richtung aus.');
$GLOBALS['TL_LANG']['tl_li_contact']['note']          = array('Notiz', 'Bitte geben Sie die Notiz ein.');
$GLOBALS['TL_LANG']['tl_li_contact']['addAttachment'] = array('Anlage hinzufügen', 'Dem Kontakt eine Anlage hinzufügen.');
$GLOBALS['TL_LANG']['tl_li_contact']['attachment']    = array('Anlage', 'Bitte wählen Sie eine Anlage aus.');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_li_contact']['contact_legend']    = 'Kontakt';
$GLOBALS['TL_LANG']['tl_li_contact']['date_legend']       = 'Datum und Zeit';
$GLOBALS['TL_LANG']['tl_li_contact']['note_legend']       = 'Notiz';
$GLOBALS['TL_LANG']['tl_li_contact']['attachment_legend'] = 'Anlage';

/**
 * References
 */
$GLOBALS['TL_LANG']['tl_li_contact']['categorys']['phone']     = 'Telefonat';
$GLOBALS['TL_LANG']['tl_li_contact']['categorys']['email']     = 'E-Mail';
$GLOBALS['TL_LANG']['tl_li_contact']['categorys']['mail']      = 'Brief';
$GLOBALS['TL_LANG']['tl_li_contact']['categorys']['fax']       = 'Fax';
$GLOBALS['TL_LANG']['tl_li_contact']['categorys']['direct']    = 'Kundenbesuch';
$GLOBALS['TL_LANG']['tl_li_contact']['results']['reached']     = 'Erreicht';
$GLOBALS['TL_LANG']['tl_li_contact']['results']['not_reached'] = 'Nicht erreicht';
$GLOBALS['TL_LANG']['tl_li_contact']['directions']['incoming'] = 'Eingehend';
$GLOBALS['TL_LANG']['tl_li_contact']['directions']['outgoing'] = 'Ausgehend';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_li_contact']['new']    = array('Neuer Kontakt', 'Einen neuen Kontakt anlegen');
$GLOBALS['TL_LANG']['tl_li_contact']['edit']   = array('Kontakt bearbeiten', 'Kontakt mit der ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_li_contact']['copy']   = array('Kontakt duplizieren', 'Kontakt mit der ID %s duplizieren');
$GLOBALS['TL_LANG']['tl_li_contact']['delete'] = array('Kontakt löschen', 'Kontakt mit der ID %s löschen');
$GLOBALS['TL_LANG']['tl_li_contact']['show']   = array('Kontaktdetails', 'Details des Kontakts mit der ID %s anzeigen');

?>