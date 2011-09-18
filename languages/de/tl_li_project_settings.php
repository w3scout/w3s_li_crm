<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */

$GLOBALS['TL_LANG']['tl_li_project_settings']['project_number_legend'] = 'Projektnummer';

$GLOBALS['TL_LANG']['tl_li_project_settings']['li_crm_project_number_generation'] = array('Generierung der Projektnummer', 'Bitte geben Sie die Kombination von Insert-Tags und Text ein, durch die eine Projektnummer generiert werden soll. Mit {{countProjects::x}} wird die aktuelle Anzahl an Projekten ausgegeben. Der x-Wert bestimmt auf wie viele Stellen die Nummer mit Nullen aufgefüllt werden soll.');
$GLOBALS['TL_LANG']['tl_li_project_settings']['li_crm_project_number_generation_start'] = array('Projektzähler Start', 'Bitte geben Sie die Zahl ein, bei der der Projektzähler startet. Dadurch können Sie die Nummern z. B. ab 100 starten lassen.');

$GLOBALS['TL_LANG']['tl_li_project_settings']['edit'] = 'Projekteinstellungen bearbeiten';