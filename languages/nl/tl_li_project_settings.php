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
$GLOBALS['TL_LANG']['tl_li_project_settings']['li_crm_project_number_generation']       = array('Generatie project nummer', 'Voer een combinatie van insert tages en tekst hoe het klantnummer wordt gegenereerd. Er kan gebruik worden gemaakt van {{countProjects::x}} voor het verkrijgen van project nummers. De waarde van x stelt in hoe veel cijfers worden gebruikt, de rest wordt opgevult met nullen.');
$GLOBALS['TL_LANG']['tl_li_project_settings']['li_crm_project_number_generation_start'] = array('Project nummer startgetal', 'Voer een getal in waarmee het project nummer begint. Hierdoor kan bijvoorbeeld het project nummer beginnen met 100.');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_li_project_settings']['project_number_legend'] = 'Project nummer';

/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_li_project_settings']['edit']   = 'Bewerk project instellingen';

?>