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
$GLOBALS['TL_LANG']['tl_li_project_settings']['li_crm_project_number_generation']       = array('Project number generation', 'Please enter a combination of insert tags and text through which the project number will be generated. You can use {{countProjects::x}} to get the current number of projects. The x-Value defines on how many letters will be used. The rest will be filled with zeros.');
$GLOBALS['TL_LANG']['tl_li_project_settings']['li_crm_project_number_generation_start'] = array('Project counter start', 'Please enter a number at which the project counter starts. Through this you\'re able to, for example, let the number start at 100.');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_li_project_settings']['project_number_legend'] = 'Project number';

/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_li_project_settings']['edit']   = 'Edit project settings';

?>