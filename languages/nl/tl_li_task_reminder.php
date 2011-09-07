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
$GLOBALS['TL_LANG']['tl_li_task_reminder']['toCustomer']       = array('Klant', 'Selecteer een klant.');
$GLOBALS['TL_LANG']['tl_li_task_reminder']['toTask']        = array('Taak', 'Selecteer een taak.');
$GLOBALS['TL_LANG']['tl_li_task_reminder']['remindOnce']       = array('Herinner eenmalig', 'Moet deze herinnering eenmalig verzonden worden?');
$GLOBALS['TL_LANG']['tl_li_task_reminder']['remindDate']       = array('Herinnerings datum', 'Voer de datum in dat de herinnering moet worden verzonden.');
$GLOBALS['TL_LANG']['tl_li_task_reminder']['remindRepeatedly'] = array('Herinnering herhalen', 'Moet de herinnering worden herhaald?');
$GLOBALS['TL_LANG']['tl_li_task_reminder']['remindInterval']   = array('Interval', 'Selecteer interval');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_li_task_reminder']['reminder_legend']   = 'Herinnering';
$GLOBALS['TL_LANG']['tl_li_task_reminder']['once_legend']       = 'Eenmalig';
$GLOBALS['TL_LANG']['tl_li_task_reminder']['repeatedly_legend'] = 'Meerdere malen';

/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_li_task_reminder']['noCustomer']                = 'Geen klant';
$GLOBALS['TL_LANG']['tl_li_task_reminder']['remindInterval']['daily']   = 'Dagelijks';
$GLOBALS['TL_LANG']['tl_li_task_reminder']['remindInterval']['weekly']  = 'Weekelijks';
$GLOBALS['TL_LANG']['tl_li_task_reminder']['remindInterval']['monthly'] = 'Maandelijks';
$GLOBALS['TL_LANG']['tl_li_task_reminder']['remindInterval']['yearly']  = 'Jaarlijks';
$GLOBALS['TL_LANG']['tl_li_task_reminder']['subject']                   = 'Taak herinnering';
$GLOBALS['TL_LANG']['tl_li_task_reminder']['text']                      = 'Taak herinnering voor taak "%s" van %s.';
$GLOBALS['TL_LANG']['tl_li_task_reminder']['customerRemark']            = 'Deze Taak hoort bij klant "%s %s".';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_li_task_reminder']['new']    = array('Nieuwe Herinnering', 'Maak een herinnering');
$GLOBALS['TL_LANG']['tl_li_task_reminder']['edit']   = array('Herinnering bewerken', 'Wijzig herinnering ID %s');
$GLOBALS['TL_LANG']['tl_li_task_reminder']['copy']   = array('Herinnering kopieren', 'Dupliceer herinnering ID %s');
$GLOBALS['TL_LANG']['tl_li_task_reminder']['delete'] = array('Herinnering verwijderen', 'Verwijder herinnering ID %s');
$GLOBALS['TL_LANG']['tl_li_task_reminder']['show']   = array('Toon details herinnering', 'Toon details van herinnering ID %s');

?>