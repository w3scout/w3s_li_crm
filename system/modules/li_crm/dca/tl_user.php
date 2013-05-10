<?php

/**
 * @copyright   w3scouts.com
 * @author      Darko Selesi <hallo@w3scouts.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */

/**
 * Table tl_user
 */
$GLOBALS['TL_DCA']['tl_user']['palettes']['extend'] = str_replace('fop;', 'fop;{licrm_invoice_legend},licrm_invoicep;', $GLOBALS['TL_DCA']['tl_user']['palettes']['extend']);
$GLOBALS['TL_DCA']['tl_user']['palettes']['custom'] = str_replace('fop;', 'fop;{licrm_invoice_legend},licrm_invoicep;', $GLOBALS['TL_DCA']['tl_user']['palettes']['custom']);


$GLOBALS['TL_DCA']['tl_user']['fields']['licrm_invoicep'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_user']['licrm_invoicep'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'options'                 => array('print', 'send'),
    'reference'               => &$GLOBALS['TL_LANG']['MSC'],
    'eval'                    => array('multiple'=>true),
    'sql'                     => "blob NULL"
);