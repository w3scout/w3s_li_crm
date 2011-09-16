<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */
$GLOBALS['TL_LANG']['tl_li_contact'] = array(
    'title'         => array('Titel', 'Bitte geben Sie den Titel ein.'),
    'category'      => array('Kategorie', 'Bitte wählen Sie die Kategorie aus.'),
    'startDate'     => array('Startdatum', 'Bitte geben Sie das Startdatum gemäß des globalen Datumsformats ein.'),
    'startTime'     => array('Startzeit', 'Bitte geben Sie die Startzeit gemäß des globalen Zeitformats ein.'),
    'addEnd'        => array('Ende hinzufügen', 'Dem Kontakt Enddatum und -zeit hinzufügen.'),
    'endDate'       => array('Enddatum', 'Lassen Sie das Feld leer, um ein eintägiges Event zu erstellen.'),
    'endTime'       => array('Endzeit', 'Geben Sie dieselbe Start- und Endzeit ein, um ein Event mit offenem Ende zu erstellen.'),
    'result'        => array('Ergebnis', 'Bitte wählen Sie das Ergebnis aus.'),
    'direction'     => array('Richtung', 'Bitte wählen Sie die Richtung aus.'),
    'note'          => array('Notiz', 'Bitte geben Sie die Notiz ein.'),
    'addAttachment' => array('Anlage hinzufügen', 'Dem Kontakt eine Anlage hinzufügen.'),
    'attachment'    => array('Anlage', 'Bitte wählen Sie eine Anlage aus.'),

    'contact_legend'    => 'Kontakt',
    'date_legend'       => 'Datum und Zeit',
    'note_legend'       => 'Notiz',
    'attachment_legend' => 'Anlage',
    
    'categorys' => array(
        'phone'     => 'Telefonat',
        'email'     => 'E-Mail',
        'mail'      => 'Brief',
        'fax'       => 'Fax',
        'direct'    => 'Kundenbesuch',
    ),
    'results' => array(
        'reached'       => 'Erreicht',
        'not_reached'   => 'Nicht erreicht',
    ),
    'directions' => array(
        'incoming'  => 'Eingehend',
        'outgoing'  => 'Ausgehend',
    ),

    'new'       => array('Neuer Kontakt', 'Einen neuen Kontakt anlegen'),
    'edit'      => array('Kontakt bearbeiten', 'Kontakt mit der ID %s bearbeiten'),
    'copy'      => array('Kontakt duplizieren', 'Kontakt mit der ID %s duplizieren'),
    'delete'    => array('Kontakt löschen', 'Kontakt mit der ID %s löschen'),
    'show'      => array('Kontaktdetails', 'Details des Kontakts mit der ID %s anzeigen'),
);
