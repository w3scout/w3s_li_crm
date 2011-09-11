<?php

/**
 * @copyright	Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author		apoy2k
 * @license		MIT (see /LICENSE.txt for further information)
 */
if (!defined('TL_ROOT'))
	die('You cannot access this file directly!');

$GLOBALS['TL_LANG']['tl_li_timekeeping_settings'] = array(
	'edit' => 'Stundenerfassung einstellen',
	'calendar' => 'Kalender einstellen',
	'calendarWeekMode' => array(
		'Beginn einer Kalenderwoche',
		'Legt fest, wann eine Kalenderwoche beginnt und wie mit dem Jahreswechsel beim Zählen der Kalenderwochen umgegangen '.
		'werden soll.'),
	
	'calendarWeekModeOptions' => array(
		'7' => 'Montags / Einheitlich',
		'3' => 'Montags / Mehrheitlich',
		'2' => 'Sonntags / Einheitlich',
		'6' => 'Sonntags / Mehrheitlich')
);
