<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */

$GLOBALS['TL_LANG']['tl_li_invoice']['invoice_legend'] = 'Rechnung';
$GLOBALS['TL_LANG']['tl_li_invoice']['pdf_legend'] = 'PDF-Datei';
$GLOBALS['TL_LANG']['tl_li_invoice']['settings_legend'] = 'Einstellungen';
$GLOBALS['TL_LANG']['tl_li_invoice']['generation_legend'] = 'Generierung';

$GLOBALS['TL_LANG']['tl_li_invoice']['toCustomer'] = array('Kunde', 'Bitte wählen Sie einen Kunden aus.');
$GLOBALS['TL_LANG']['tl_li_invoice']['toCategory'] = array('Rechnungskategorie', 'Bitte wählen Sie die Rechnungskategorie aus.');
$GLOBALS['TL_LANG']['tl_li_invoice']['title'] = array('Titel', 'Bitte geben Sie den Titel ein.');
$GLOBALS['TL_LANG']['tl_li_invoice']['alias'] = array('Alias', 'Bitte geben Sie den Alias ein.');
$GLOBALS['TL_LANG']['tl_li_invoice']['invoiceDate'] = array('Rechnungsdatum', 'Bitte geben Sie das Rechnungsdatum ein.');
$GLOBALS['TL_LANG']['tl_li_invoice']['performanceDate'] = array('Leistungsdatum', 'Bitte geben Sie das Leistungsdatum ein.');
$GLOBALS['TL_LANG']['tl_li_invoice']['price'] = array('Preis', 'Bitte geben Sie den Preis ein.');
$GLOBALS['TL_LANG']['tl_li_invoice']['maturity'] = array('Laufzeit', 'Geben Sie die Anzahl der Tage ein, die der Kunde zur Bezahlung der Rechnung Zeit hat, falls diese von der Standard- und Templateeinstellungen abweicht.');
$GLOBALS['TL_LANG']['tl_li_invoice']['file'] = array('Rechnung', 'Bitte wählen Sie die Rechnung aus.');
$GLOBALS['TL_LANG']['tl_li_invoice']['isOut'] = array('Ausgangsrechnung?', 'Ist die Rechnung eine Ausgangsrechnung?');
$GLOBALS['TL_LANG']['tl_li_invoice']['isSingular'] = array('Einmalige Rechnung?', 'Ist die Rechnung eine einmalige Rechnung?');
$GLOBALS['TL_LANG']['tl_li_invoice']['enableGeneration'] = array('Generierung aktivieren', 'Rechnungsgenerierung aktivieren.');
$GLOBALS['TL_LANG']['tl_li_invoice']['headline'] = array('Überschrift', 'Bitte geben Sie die Überschrift ein.');
$GLOBALS['TL_LANG']['tl_li_invoice']['toTemplate'] = array('Rechnungstemplate', 'Bitte wählen Sie das Rechnungstemplate aus.');
$GLOBALS['TL_LANG']['tl_li_invoice']['toAddress'] = array('Rechnungsadresse', 'Bitte wählen Sie die Rechnungsadresse aus.');

$GLOBALS['TL_LANG']['tl_li_invoice']['new'] = array('Neue Rechnung', 'Eine neue Rechnung erstellen');
$GLOBALS['TL_LANG']['tl_li_invoice']['edit'] = array('Rechnung editieren', 'Die Rechnung mit der ID %s editieren');
$GLOBALS['TL_LANG']['tl_li_invoice']['copy'] = array('Rechnung kopieren', 'Die Rechnung mit der ID %s kopieren');
$GLOBALS['TL_LANG']['tl_li_invoice']['delete'] = array('Rechnung löschen', 'Die Rechnung mit der ID %s löschen');
$GLOBALS['TL_LANG']['tl_li_invoice']['show'] = array('Rechnung anzeigen', 'Die Rechnung mit der ID %s anzeigen');
$GLOBALS['TL_LANG']['tl_li_invoice']['generate'] = array('Rechnung generieren', 'Die Rechnung mit der ID %s generieren');
$GLOBALS['TL_LANG']['tl_li_invoice']['dispatch'] = array('Rechnung verschicken', 'Die Rechnung mit der ID %s an den Kunden schicken');
$GLOBALS['TL_LANG']['tl_li_invoice']['reports'] = array('Berichte', 'Den Verlauf der Rechnungen anzeigen');
$GLOBALS['TL_LANG']['tl_li_invoice']['reminder'] = array('Erinnerungen', 'Rechnungserinnerungen verwalten');
$GLOBALS['TL_LANG']['tl_li_invoice']['showFile'] = array('Rechnungsdatei anzeigen', 'Die Rechnungsdatei mit der ID %s anzeigen');

$GLOBALS['TL_LANG']['tl_li_invoice']['report_month'] = 'Rechnungsverlauf - Monatsübersicht';
$GLOBALS['TL_LANG']['tl_li_invoice']['report_year'] = 'Rechnungsverlauf - Jahresübersicht';
$GLOBALS['TL_LANG']['tl_li_invoice']['report_income'] = 'Einnahmen';
$GLOBALS['TL_LANG']['tl_li_invoice']['report_expenses'] = 'Ausgaben';

$GLOBALS['TL_LANG']['tl_li_invoice']['income'] = 'Einnahme';
$GLOBALS['TL_LANG']['tl_li_invoice']['expense'] = 'Ausgabe';
$GLOBALS['TL_LANG']['tl_li_invoice']['tax_number'] = 'Steuernummer';
$GLOBALS['TL_LANG']['tl_li_invoice']['date'] = 'Datum';
$GLOBALS['TL_LANG']['tl_li_invoice']['invoice_number'] = 'Rechnungs-Nr.';
$GLOBALS['TL_LANG']['tl_li_invoice']['introduction_male'] = 'Sehr geehrter Herr %s,<br />für Ihren Auftrag bedanke ich mich und berechne folgendes für meine Leistungen.';
$GLOBALS['TL_LANG']['tl_li_invoice']['introduction_female'] = 'Sehr geehrte Frau %s,<br />für Ihren Auftrag bedanke ich mich und berechne folgendes für meine Leistungen.';
$GLOBALS['TL_LANG']['tl_li_invoice']['position_quantity'] = 'Anzahl';
$GLOBALS['TL_LANG']['tl_li_invoice']['position_unit'] = 'Einheit';
$GLOBALS['TL_LANG']['tl_li_invoice']['position_label'] = 'Bezeichnung';
$GLOBALS['TL_LANG']['tl_li_invoice']['position_tax'] = 'Steuer';
$GLOBALS['TL_LANG']['tl_li_invoice']['position_unit_price'] = 'Einzelpreis';
$GLOBALS['TL_LANG']['tl_li_invoice']['position_total_price'] = 'Gesamtpreis';
$GLOBALS['TL_LANG']['tl_li_invoice']['performance_is_invoice_date'] = 'Das Rechnungsdatum entspricht dem Leistungsdatum.';
$GLOBALS['TL_LANG']['tl_li_invoice']['performance_date_at'] = 'Leistungsdatum: %s';
$GLOBALS['TL_LANG']['tl_li_invoice']['account_data'] = 'Kontodaten';
$GLOBALS['TL_LANG']['tl_li_invoice']['account_number'] = 'Kontonummer';
$GLOBALS['TL_LANG']['tl_li_invoice']['bank_code'] = 'BLZ';
$GLOBALS['TL_LANG']['tl_li_invoice']['bank'] = 'Bank';
$GLOBALS['TL_LANG']['tl_li_invoice']['maturity_remark'] = 'Bitte überweisen Sie den Rechnungsbetrag innerhalb der nächsten %s Tagen.';
$GLOBALS['TL_LANG']['tl_li_invoice']['greeting'] = 'Mit freundlichen Grüßen<br />%s';

$GLOBALS['TL_LANG']['tl_li_invoice']['total_netto'] = 'Rechnungsbetrag (netto)';
$GLOBALS['TL_LANG']['tl_li_invoice']['total_brutto'] = 'Rechnungsbetrag (brutto)';
$GLOBALS['TL_LANG']['tl_li_invoice']['tax'] = 'Umsatzsteuer';

$GLOBALS['TL_LANG']['tl_li_invoice']['units']['unit'] = 'Stück';
$GLOBALS['TL_LANG']['tl_li_invoice']['units']['hour'] = 'Stunde';
$GLOBALS['TL_LANG']['tl_li_invoice']['units']['month'] = 'Monat';
$GLOBALS['TL_LANG']['tl_li_invoice']['units']['year'] = 'Jahr';

$GLOBALS['TL_LANG']['tl_li_invoice']['invoice_generation'] = 'Rechnungsgenerierung';
$GLOBALS['TL_LANG']['tl_li_invoice']['path_introduction'] = 'Die Rechnung wurde erfolgreich generiert und unter folgendem Pfad abgelegt';
$GLOBALS['TL_LANG']['tl_li_invoice']['path'] = 'Pfad';
$GLOBALS['TL_LANG']['tl_li_invoice']['back_overview'] = 'Zurück zur Übersicht';

$GLOBALS['TL_LANG']['tl_li_invoice']['dispatch_subject'] = 'Rechnung';
$GLOBALS['TL_LANG']['tl_li_invoice']['dispatch_text_male'] = 'Sehr geehrter Herr %s,\n\nanbei die neue Rechnung vom %s.\n\nMit freundlichen Grüßen\n%s';
$GLOBALS['TL_LANG']['tl_li_invoice']['dispatch_text_female'] = 'Sehr geehrte Frau %s,\n\nanbei die neue Rechnung vom %s.\n\nMit freundlichen Grüßen\n%s';
$GLOBALS['TL_LANG']['tl_li_invoice']['dispatch_html_male'] = 'Sehr geehrter Herr %s,<br /><br />anbei die neue Rechnung vom %s.<br /><br />Mit freundlichen Grüßen<br />%s';
$GLOBALS['TL_LANG']['tl_li_invoice']['dispatch_html_female'] = 'Sehr geehrte Frau %s,<br /><br />anbei die neue Rechnung vom %s.<br /><br />Mit freundlichen Grüßen<br />%s';
$GLOBALS['TL_LANG']['tl_li_invoice']['invoice_dispatch'] = 'Rechnungsversand';
$GLOBALS['TL_LANG']['tl_li_invoice']['dispatch_successful'] = 'Die Rechnung wurde erfolgreich versant.';
$GLOBALS['TL_LANG']['tl_li_invoice']['dispatch_failed'] = 'Die Rechnung konnte nicht versant werden. Genauere Informationen entnehmen Sie bitte dem System Log.';