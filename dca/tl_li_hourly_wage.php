<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright	Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author		ApoY2k <apoy2k@gmail.com>
 * @license		MIT (see /LICENSE.txt for further information)
 */
$GLOBALS['TL_DCA']['tl_li_hourly_wage'] = array
(
	'config' => array
	(
		'dataContainer'	=> 'Table',
		'enableVersioning'	=> true
	),
    'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('wage'),
			'flag'                    => 11,
            'panelLayout'             => 'search,filter,limit',
		),
		'label' => array
		(
			'fields'                  => array('title'),
			'format'                  => '%s',
		),
		'global_operations' => array
		(
            'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_hourly_wage']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_hourly_wage']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_hourly_wage']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\''.
                    $GLOBALS['TL_LANG']['MSC']['deleteConfirm'].'\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_li_hourly_wage']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),
	'palettes' => array
	(
		'__selector__'	=> array(),
		'default'		=> '{wage_legend},title,wage,taxRate;'
	),
	'fields' => array
	(
		'title' => array
		(
			'label'		=> &$GLOBALS['TL_LANG']['tl_li_hourly_wage']['title'],
			'inputType'	=> 'text',
			'default'	=> '',
            'search'    => true,
			'eval'		=> array('mandatory' => true, 'tl_class' => 'w50'),
		),
		'wage' => array
		(
			'label'		=> &$GLOBALS['TL_LANG']['tl_li_hourly_wage']['wage'],
			'inputType'	=> 'text',
			'default'	=> '',
            'rgxp'      => 'digit',
            'filter'    => true,
			'eval'		=> array('mandatory' => true, 'tl_class' => 'w50'),
		),
        'taxRate' => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_li_hourly_wage']['taxRate'],
			'inputType' => 'text',
			'eval'      => array('mandatory'=>true, 'maxlength'=>3, 'tl_class'=>'w50', 'rgxp'=>'digit')
		)
	)
);
