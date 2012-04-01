<?php if (!defined('TL_ROOT')) die("You cannot access this file directly!");

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */

$GLOBALS['TL_LANG']['tl_li_invoice_template']['template_legend'] = "Rechnungstemplate";
$GLOBALS['TL_LANG']['tl_li_invoice_template']['invoice_data_legend'] = "Rechnungsdaten";
$GLOBALS['TL_LANG']['tl_li_invoice_template']['generation_path_legend'] = "Generierungspfad";

$GLOBALS['TL_LANG']['tl_li_invoice_template']['title'] = array("Titel", "Bitte geben Sie den Titel ein.");
$GLOBALS['TL_LANG']['tl_li_invoice_template']['invoice_template'] = array("Rechnungs-Template", "Bitte wählen Sie das Rechnungs-Template aus.");
$GLOBALS['TL_LANG']['tl_li_invoice_template']['logo'] = array("Logo", "Bitte wählen Sie das Logo aus.");
$GLOBALS['TL_LANG']['tl_li_invoice_template']['maturity'] = array("Laufzeit", "Geben Sie die Anzahl der Tage ein, die der Kunde zur Bezahlung der Rechnung Zeit hat, falls diese von der Standardeinstellungen abweicht.");
$GLOBALS['TL_LANG']['tl_li_invoice_template']['descriptionBefore'] = array("Beschreibung vor den Positionen", "Bitte geben Sie die Beschreibung vor den Positionen ein.");
$GLOBALS['TL_LANG']['tl_li_invoice_template']['descriptionAfter'] = array("Beschreibung nach den Positionen", "Bitte geben Sie die Beschreibung nach den Positionen ein.");
$GLOBALS['TL_LANG']['tl_li_invoice_template']['basePath'] = array("Basispfad", "Bitte wählen Sie den Basisordner aus.");
$GLOBALS['TL_LANG']['tl_li_invoice_template']['periodFolder'] = array("Periodischen Ordner erstellen?", "Soll ein zusätzlicher periodischer Ordner erstellt werden?");

$GLOBALS['TL_LANG']['tl_li_invoice_template']['periods']['daily'] = "Täglich";
$GLOBALS['TL_LANG']['tl_li_invoice_template']['periods']['weekly'] = "Wöchentlich";
$GLOBALS['TL_LANG']['tl_li_invoice_template']['periods']['monthly'] = "Monatlich";
$GLOBALS['TL_LANG']['tl_li_invoice_template']['periods']['yearly'] = "Jährlich";

$GLOBALS['TL_LANG']['tl_li_invoice_template']['new'] = array("Neues Rechnungstemplate", "Ein neues Rechnungstemplate anlegen");
$GLOBALS['TL_LANG']['tl_li_invoice_template']['edit'] = array("Rechnungstemplate bearbeiten", "Das Rechnungstemplate mit der ID %s bearbeiten");
$GLOBALS['TL_LANG']['tl_li_invoice_template']['copy'] = array("Rechnungstemplate duplizieren", "Das Rechnungstemplate mit der ID %s duplizieren");
$GLOBALS['TL_LANG']['tl_li_invoice_template']['delete'] = array("Rechnungstemplate löschen", "Das Rechnungstemplate mit der ID %s löschen");
$GLOBALS['TL_LANG']['tl_li_invoice_template']['show'] = array("Rechnungstemplate anzeigen", "Das Rechnungstemplate mit der ID %s anzeigen");
