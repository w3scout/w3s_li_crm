<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */
$GLOBALS['TL_LANG']['tl_li_invoice'] = array(
    'toCustomer'        => array('Kunde', 'Bitte wählen Sie einen Kunden aus.'),
    'toCategory'        => array('Rechnungskategorie', 'Bitte wählen Sie die Rechnungskategorie aus.'),
    'title'             => array('Titel', 'Bitte geben Sie den Titel ein.'),
    'alias'             => array('Alias', 'Bitte geben Sie den Alias ein.'),
    'invoiceDate'       => array('Rechnungsdatum', 'Bitte geben Sie das Rechnungsdatum ein.'),
    'performanceDate'   => array('Leistungsdatum', 'Bitte geben Sie das Leistungsdatum ein.'),
    'price'             => array('Preis', 'Bitte geben Sie den Preis ein.'),
    'file'              => array('Rechnung', 'Bitte wählen Sie die Rechnung aus.'),
    'isOut'             => array('Ausgangsrechnung?', 'Ist die Rechnung eine Ausgangsrechnung?'),
    'isSingular'        => array('Einmalige Rechnung?', 'Ist die Rechnung eine einmalige Rechnung?'),
    'enableGeneration'  => array('Generierung aktivieren', 'Rechnungsgenerierung aktivieren.'),
    'toTemplate'        => array('Rechnungstemplate', 'Bitte wählen Sie das Rechnungstemplate aus.'),
    'toAddress'         => array('Rechnungsadresse', 'Bitte wählen Sie die Rechnungsadresse aus.'),
    
    'invoice_legend'    => 'Rechnung',
    'pdf_legend'        => 'PDF-Datei',
    'settings_legend'   => 'Einstellungen',
    'generation_legend' => 'Generierung',
    
    'income'                      => 'Einnahme',
    'expense'                     => 'Ausgabe',
    'tax_number'                  => 'Steuernummer',
    'date'                        => 'Datum',
    'invoice_number'              => 'Rechnungs-Nr.',
    'introduction_male'           => 'Sehr geehrter Herr %s,<br />für Ihren Auftrag bedanke ich mich und berechne folgendes für meine Leistungen.',
    'introduction_female'         => 'Sehr geehrte Frau %s,<br />für Ihren Auftrag bedanke ich mich und berechne folgendes für meine Leistungen.',
    'position_quantity'           => 'Anzahl',
    'position_unit'               => 'Einheit',
    'position_label'              => 'Bezeichnung',
    'position_tax'                => 'Steuer',
    'position_unit_price'         => 'Einzelpreis',
    'position_total_price'        => 'Gesamtpreis',
    'performance_is_invoice_date' => 'Das Rechnungsdatum entspricht dem Leistungsdatum.',
    'performance_date_at'         => 'Leistungsdatum: %s',
    'transfer_remark'             => 'Bitte überweisen Sie den Rechnungsbetrag innerhalb der nächsten 14 Tage auf das nachfolgende Konto.',
    'account_data'                => 'Kontodaten',
    'account_number'              => 'Kontonummer',
    'bank_code'                   => 'BLZ',
    'bank'                        => 'Bank',
    'greeting'                    => 'Mit freundlichen Grüßen<br />%s',
    
    'total_netto'   => 'Rechnungsbetrag (netto)',
    'total_brutto'  => 'Rechnungsbetrag (brutto)',
    'tax'           => 'Umsatzsteuer',
    
    'units' => array(
        'unit'  => 'Stück',
        'hour'  => 'Stunde',
        'month' => 'Monat',
        'year'  => 'Jahr',
    ),
    
    'invoice_generation'    => 'Rechnungsgenerierung',
    'path_introduction'     => 'Die Rechnung wurde erfolgreich generiert und unter folgendem Pfad abgelegt',
    'path'                  => 'Pfad',
    'back_overview'         => 'Zurück zur Übersicht',
    
    'new'       => array('Neue Rechnung', 'Neue Rechnung erstellen'),
    'edit'      => array('Rechnung editieren', 'Die Rechnung mit der ID %s editieren'),
    'copy'      => array('Rechnung kopieren', 'Die Rechnung mit der ID %s kopieren'),
    'delete'    => array('Rechnung löschen', 'Die Rechnung mit der ID %s löschen'),
    'show'      => array('Rechnungdetails anzeigen', 'Die Details der Rechnung mit der ID %s anzeigen'),
    
    'reminder' => array('Rechnungserinnerungen', 'Rechnungserinnerungen verwalten'),
);
