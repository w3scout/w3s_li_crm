<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */
$GLOBALS['TL_LANG']['tl_li_invoice_template'] = array(
    'title'             => array('Titel', 'Bitte geben Sie den Titel ein.'),
    'invoice_template'  => array('Rechnungs-Template', 'Bitte wählen Sie das Rechnungs-Template aus.'),
    'logo'              => array('Logo', 'Bitte wählen Sie das Logo aus.'),
    'basePath'          => array('Basispfad', 'Bitte wählen Sie den Basisordner aus.'),
    'periodFolder'      => array('Periodischen Ordner erstellen?', 'Soll ein zusätzlicher periodischer Ordner erstellt werden?'),
    
    'template_legend'           => 'Rechnungstemplate',
    'generation_path_legend'    => 'Generierungspfad',
    
    'periods' => array(
        'daily'     => 'Täglich',
        'weekly'    => 'Wöchentlich',
        'monthly'   => 'Monatlich',
        'yearly'    => 'Jährlich',
    ),
    
    'new'       => array('Neues Rechnungstemplate', 'Eine neues Rechnungstemplate anlegen'),
    'edit'      => array('Rechnungstemplate bearbeiten', 'Rechnungstemplate mit der ID %s bearbeiten'),
    'copy'      => array('Rechnungstemplate duplizieren', 'Rechnungstemplate mit der ID %s duplizieren'),
    'delete'    => array('Rechnungstemplate löschen', 'Rechnungstemplate mit der ID %s löschen'),
    'show'      => array('Rechnungstemplatedetails', 'Details der Rechnungstemplate mit der ID %s anzeigen'),
);
