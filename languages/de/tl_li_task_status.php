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
$GLOBALS['TL_LANG']['tl_li_task_status']['title']          = array('Titel', 'Bitte geben Sie den Titel ein.');
$GLOBALS['TL_LANG']['tl_li_task_status']['orderNumber']    = array('Sortiernummer', 'Bitte geben Sie die Sortiernummer ein.');
$GLOBALS['TL_LANG']['tl_li_task_status']['icon']           = array('Icon', 'Bitte wählen Sie das Icon aus. Es sollte die Maße von 16x16 haben.');
$GLOBALS['TL_LANG']['tl_li_task_status']['isTaskDisabled'] = array('Aufgabe deaktiviert', 'Soll die Aufgabe mit diesem Status deaktiviert dargestellt werden?');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_li_task_status']['status_legend']   = 'Status';
$GLOBALS['TL_LANG']['tl_li_task_status']['settings_legend'] = 'Einstellungen';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_li_task_status']['new']    = array('Neuer Status', 'Einen neuen Status anlegen');
$GLOBALS['TL_LANG']['tl_li_task_status']['show']   = array('Statusdetails', 'Details des Status ID %s anzeigen');
$GLOBALS['TL_LANG']['tl_li_task_status']['edit']   = array('Status bearbeiten', 'Status ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_li_task_status']['copy']   = array('Status duplizieren', 'Status ID %s duplizieren');
$GLOBALS['TL_LANG']['tl_li_task_status']['delete'] = array('Status löschen', 'Status ID %s löschen');

/**
 * Additional
 */
$GLOBALS['TL_LANG']['tl_li_task_status']['defaultIcon'] = 'Standard';

?>