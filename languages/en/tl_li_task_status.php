<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */
$GLOBALS['TL_LANG']['tl_li_task_status'] = array(
    'title'             => array('Title', 'Please enter a title.'),
    'orderNumber'       => array('Order number', 'Please enter an order number.'),
    'icon'              => array('Icon', 'Please choose an icon. The icons dimensions should be 16x16 pixels.'),
    'isTaskDisabled'    => array('Disabled', 'Wether the task is considered disabled when in this status.'),
    
    'status_legend'     => 'Status',
    'settings_legend'   => 'Settings',
    
    'new'       => array('New status', 'Create a new status'),
    'show'      => array('Show status', 'Show status %s'),
    'edit'      => array('Edit status', 'Edit status %s'),
    'copy'      => array('Duplicate status', 'Duplicate status %s'),
    'delete'    => array('Delete status', 'Delete status %s'),
    
    'defaultIcon' => 'Standard',
);
