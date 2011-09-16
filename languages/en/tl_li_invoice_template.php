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
    'title'             => array('Title', 'Please enter a title.'),
    'invoice_template'  => array('Invoice template', 'Please choose an invoice template.'),
    'logo'              => array('Logo', 'Please choose a logo.'),
    'basePath'          => array('Base path', 'Please choose a base path.'),
    'periodFolder'      => array('Create periodic folder', 'Wether a periodic folder should be created.'),
    
    'template_legend'           => 'Invoice template',
    'generation_path_legend'    => 'Creation path',
    
    'periods' => array(
        'daily'     => 'Daily',
        'weekly'    => 'Weekly',
        'monthly'   => 'Monthly',
        'yearly'    => 'Yearly',
    ),
    
    'new'       => array('New invoice template', 'Create a new invoice template.'),
    'edit'      => array('Edit invoice template', 'Edit invoice template %s'),
    'copy'      => array('Duplicate invoice template', 'Duplicate invoice template %s'),
    'delete'    => array('Delete invoice template', 'Delete invoice template %s'),
    'show'      => array('Show invoice template', 'Show invoice template %s'),
);
