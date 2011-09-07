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
$GLOBALS['TL_LANG']['tl_li_task_reminder']['toCustomer']       = array('Kunde', 'Bitte wählen Sie einen Kunden aus.');
$GLOBALS['TL_LANG']['tl_li_task_reminder']['toTask']           = array('Aufgabe', 'Bitte wählen Sie die Aufgabe aus.');
$GLOBALS['TL_LANG']['tl_li_task_reminder']['remindOnce']       = array('Einmalig erinnern', 'Soll einmalig eine Erinnerung verschickt werden?');
$GLOBALS['TL_LANG']['tl_li_task_reminder']['remindDate']       = array('Erinnerungsdatum', 'Bitte geben Sie das Datum, an dem die Erinnerung verschickt werden soll, ein.');
$GLOBALS['TL_LANG']['tl_li_task_reminder']['remindRepeatedly'] = array('Wiederholt erinnern', 'Soll die Erinnerung im Intervall bis zur Deadline verschickt werden?');
$GLOBALS['TL_LANG']['tl_li_task_reminder']['remindInterval']   = array('Intervall', 'Bitte wählen Sie den Intervall aus.');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_li_task_reminder']['reminder_legend']   = 'Erinnerung';
$GLOBALS['TL_LANG']['tl_li_task_reminder']['once_legend']       = 'Einmalig';
$GLOBALS['TL_LANG']['tl_li_task_reminder']['repeatedly_legend'] = 'Wiederholt';

/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_li_task_reminder']['noCustomer']                = 'Kein Kunde';
$GLOBALS['TL_LANG']['tl_li_task_reminder']['remindInterval']['daily']   = 'Täglich';
$GLOBALS['TL_LANG']['tl_li_task_reminder']['remindInterval']['weekly']  = 'Wöchentlich';
$GLOBALS['TL_LANG']['tl_li_task_reminder']['remindInterval']['monthly'] = 'Monatlich';
$GLOBALS['TL_LANG']['tl_li_task_reminder']['remindInterval']['yearly']  = 'Jährlich';
$GLOBALS['TL_LANG']['tl_li_task_reminder']['subject']                   = 'Aufgabenerinnerung';
$GLOBALS['TL_LANG']['tl_li_task_reminder']['text']                      = 'Aufgabenerinnerung für die Aufgabe "%s" mit der Deadline %s.';
$GLOBALS['TL_LANG']['tl_li_task_reminder']['customerRemark']            = 'Die Aufgabe gehört zum Kunden "%s %s".';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_li_task_reminder']['new']    = array('Neue Erinnerung', 'Neue Erinnerung erstellen');
$GLOBALS['TL_LANG']['tl_li_task_reminder']['edit']   = array('Erinnerung editieren', 'Die Erinnerung mit der ID %s editieren');
$GLOBALS['TL_LANG']['tl_li_task_reminder']['copy']   = array('Erinnerung kopieren', 'Die Erinnerung mit der ID %s kopieren');
$GLOBALS['TL_LANG']['tl_li_task_reminder']['delete'] = array('Erinnerung löschen', 'Die Erinnerung mit der ID %s löschen');
$GLOBALS['TL_LANG']['tl_li_task_reminder']['show']   = array('Erinnerungdetails anzeigen', 'Die Details der Erinnerung mit der ID %s anzeigen');

?>