<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @author     ApoY2k <apoy2k@gmail.com>
 * @license    MIT (see /LICENSE.txt for further information)
 */

/**
 * Table tl_member_group
 */

$GLOBALS['TL_DCA']['tl_member_group']['palettes']['default'] = $GLOBALS['TL_DCA']['tl_member_group']['palettes']['default'].";{alexf_legend},alexf;";

$GLOBALS['TL_DCA']['tl_member_group']['fields']['alexf'] = array
(
    'label'                 => &$GLOBALS['TL_LANG']['tl_member_group']['alexf'],
    'exclude'               => true,
    'inputType'             => 'checkbox',
    'options_callback'      => array('LiCRM\MemberGroup', 'getExcludedFields'),
    'eval'                  => array('multiple'=>true, 'size'=>36),
    'sql'                     => "blob NULL"
);
