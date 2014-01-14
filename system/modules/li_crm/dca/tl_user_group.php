<?php

/**
 * @copyright   w3scouts.com
 * @author      Darko Selesi <hallo@w3scouts.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */

/**
 * Table tl_user_group
 */

$GLOBALS['TL_DCA']['tl_user_group']['palettes']['default'] = str_replace('fop;', 'fop;{licrm_invoice_legend},licrm_invoicep;', $GLOBALS['TL_DCA']['tl_user_group']['palettes']['default']);

$GLOBALS['TL_DCA']['tl_user_group']['fields']['licrm_invoicep'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_user_group']['licrm_invoicep'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'options'                 => array('print', 'send'),
    'reference'               => &$GLOBALS['TL_LANG']['MSC'],
    'eval'                    => array('multiple'=>true),
    'sql'                     => "blob NULL"
);
