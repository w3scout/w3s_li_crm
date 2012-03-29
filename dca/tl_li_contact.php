<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */

/**
 * Table tl_li_contact
 */
$GLOBALS['TL_DCA']['tl_li_contact'] = array
(
	// Config
	'config' => array
	(
        'ptable'					=> 'tl_member',
        'dataContainer'             => 'Table',
		'enableVersioning'			=> true
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                  => 4,
			'headerFields'			=> array('firstname','lastname', 'phone', 'fax', 'mobile', 'email'),
			'fields'                => array('startDate', 'title'),
			'disableGrouping'       => true,
			'panelLayout'           => 'filter;search,limit',
			'child_record_callback' => array('Contact','renderLabel')
		),
		'label' => array
		(
			'fields'                => array('title'),
			'format'                => '%s'
		),
		'global_operations' => array
		(
            'all' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'              => 'act=select',
				'class'             => 'header_edit_all',
				'attributes'        => 'onclick="Backend.getScrollOffset();"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_contact']['edit'],
				'href'              => 'act=edit',
				'icon'              => 'edit.gif'
			),
			'copy' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_contact']['copy'],
				'href'              => 'act=copy',
				'icon'              => 'copy.gif'
			),
			'delete' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_contact']['delete'],
				'href'              => 'act=delete',
				'icon'              => 'delete.gif',
				'attributes'        => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_contact']['show'],
				'href'              => 'act=show',
				'icon'              => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'              => array('addEnd', 'addAttachment'),
		'default'                   => '{contact_legend}, title, category, result, direction;{date_legend}, startDate, startTime, addEnd;{note_legend},note;{attachment_legend},addAttachment'
	),

	// Subpalettes
	'subpalettes' => array
	(
		'addEnd'                    => 'endDate,endTime',
		'addAttachment'             => 'attachment'
	),

	// Fields
	'fields' => array
	(
        'title' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_contact']['title'],
			'inputType'             => 'text',
			'exclude'   			=> true,
			'eval'                  => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50')
		),
		'category' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_contact']['category'],
			'inputType'             => 'select',
			'exclude'   			=> true,
			'filter'                => true,
			'options'               => array('phone', 'email', 'mail', 'fax', 'direct'),
			'reference'             => &$GLOBALS['TL_LANG']['tl_li_contact']['categories'],
			'eval'                  => array('mandatory'=>true, 'chosen'=>true, 'maxlength'=>250, 'tl_class'=>'w50')
		),
		'result' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_contact']['result'],
            'filter'                => true,
            'sorting'               => true,
			'inputType'             => 'select',
			'exclude'   			=> true,
            'options'               => array('reached', 'not_reached'),
            'reference'             => &$GLOBALS['TL_LANG']['tl_li_contact']['results'],
			'eval'                  => array('mandatory'=>true, 'tl_class'=>'w50')
		),
		'direction' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_contact']['direction'],
            'filter'                => true,
			'inputType'             => 'select',
			'exclude'   			=> true,
			'options'               => array('incoming', 'outgoing'),
            'reference'             => &$GLOBALS['TL_LANG']['tl_li_contact']['directions'],
			'eval'                  => array('mandatory'=>true, 'tl_class'=>'w50')
		),
		'startDate' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_contact']['startDate'],
			'default'               => time(),
			'inputType'             => 'text',
			'exclude'   			=> true,
			'eval'                  => array('rgxp'=>'date', 'mandatory'=>true, 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard')
		),
        'startTime' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_contact']['startTime'],
			'default'               => time(),
			'filter'                => true,
			'sorting'               => true,
			'flag'                  => 8,
			'inputType'             => 'text',
			'exclude'   			=> true,
			'eval'                  => array('rgxp'=>'time', 'mandatory'=>true, 'tl_class'=>'w50')
		),
		'addEnd' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_contact']['addEnd'],
			'inputType'             => 'checkbox',
			'exclude'   			=> true,
			'eval'                  => array('submitOnChange'=>true, 'tl_class'=>'clr')
		),
		'endDate' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_contact']['endDate'],
			'inputType'             => 'text',
			'exclude'   			=> true,
			'eval'                  => array('rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard')
		),
        'endTime' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_contact']['endTime'],
			'inputType'             => 'text',
			'exclude'   			=> true,
			'eval'                  => array('rgxp'=>'time', 'tl_class'=>'w50')
		),
        'note' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_contact']['note'],
			'search'                => true,
            'inputType'             => 'textarea',
            'exclude'   			=> true,
			'eval'                  => array('rte'=>'tinyMCE')
		),
        'addAttachment' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_contact']['addAttachment'],
			'inputType'             => 'checkbox',
			'exclude'   			=> true,
			'eval'                  => array('submitOnChange'=>true)
		),
		'attachment' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_contact']['attachment'],
			'inputType'             => 'fileTree',
			'exclude'   			=> true,
			'eval'                  => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'mandatory'=>true)
		)
	)
);
