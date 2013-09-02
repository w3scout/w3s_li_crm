<?php

/**
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */
 
 /**
  * 
  * tl_li_customer_settings
  * tl_li_project_settings
  * tl_li_invoice_settings
  * tl_li_invoice_reminder_settings
  * tl_li_invoice_dispatch_settings
  * tl_li_invoice_template
  * tl_li_task_reminder_settings
  *  
'tables'   => array(
'', 'tl_li_company_settings', 'tl_li_timekeeping_settings', 'tl_li_hourly_wage',
'tl_li_tax'),
  */

/**
 * Table tl_li_settings
 */
$GLOBALS['TL_DCA']['tl_li_settings'] = array
(
  // Config
  'config' => array
  (
    'dataContainer'             => 'Table',
    'enableVersioning'          => true,
    'ctable' => array
    (
#      'tl_li_service_type',
#      'tl_li_product_type',
#      'tl_li_task_status',
      'tl_li_invoice_category',
    ),                   
    'sql' => array
    (
      'keys' => array
       (
         'id' => 'primary'
       )
    )
  ),
  
  // List
  'list' => array
  (
    'sorting' => array
    (
      'mode'                  => 1,
      'fields'                => array('title'),
      'flag'                  => 1
    ),
    'label' => array
    (
      'fields'                => array('title'),
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
        'label'             => &$GLOBALS['TL_LANG']['tl_li_settings']['edit'],
        'href'              => 'act=edit',
        'icon'              => 'edit.gif'
      ),
      'copy' => array
      (
        'label'             => &$GLOBALS['TL_LANG']['tl_li_settings']['copy'],
        'href'              => 'act=copy',
        'icon'              => 'copy.gif'
      ),
      'delete' => array
      (
        'label'             => &$GLOBALS['TL_LANG']['tl_li_settings']['delete'],
        'href'              => 'act=delete',
        'icon'              => 'delete.gif',
        'attributes'        => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
      ),
      'show' => array
      (
        'label'             => &$GLOBALS['TL_LANG']['tl_li_settings']['show'],
        'href'              => 'act=show',
        'icon'              => 'show.gif'
      ),
      'show' => array
      (
        'label'             => &$GLOBALS['TL_LANG']['tl_li_settings']['show'],
        'href'              => 'act=show',
        'icon'              => 'show.gif'
      ),
      'invoice_category' => array
      (
        'label'               => &$GLOBALS['TL_LANG']['tl_li_settings']['invoice_category'],
        'href'                => 'table=tl_li_invoice_category',
        'icon'                => 'system/modules/li_crm/assets/invoice_categories.png'
      )
    )
  ),
  
  // Palettes
  'palettes' => array
  (
    '__selector__'          => array(''),
    'default'               => '{type_legend},title;
                                {customer_number_legend},customer_number, customer_number_start;
                                {project_number_legend},project_number, project_number_start;
                                {invoice_data_legend},invoice_maturity,invoice_number,invoice_number_start;
                                {message_legend},invoice_reminder_from,invoice_reminder_fromName,invoice_reminder_receiver;
                                {dispatch_legend},invoice_dispatch_from,invoice_dispatch_fromName;
                                {template_legend:hide},invoice_template,maturity,logo,descriptionBefore,descriptionAfter;
                                {generation_path_legend},basePath,periodFolder;
                                {message_legend},task_reminder_from,task_reminder_fromName;';
  ),
  
  // Fields
  'fields' => array
  (
    'id' => array(
      'sql'                   => "int(10) unsigned NOT NULL auto_increment"
    ),    
    'pid' => array
    (
      'sql'                   => "int(10) unsigned NOT NULL default '0'"
    ),
    'tstamp' => array
    (
      'sql'                   => "int(10) unsigned NOT NULL default '0'"
    ),
    'title' => array
    (
      'label'                 => &$GLOBALS['TL_LANG']['tl_li_product_type']['title'],
      'inputType'             => 'text',
      'exclude'               => true,
      'eval'                  => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50'),
      'sql'                   => "varchar(255) NOT NULL default ''"
     ),
    'customer_number' => array
    (
      'label'                 => &$GLOBALS['TL_LANG']['tl_li_settings']['customer_number'],
      'inputType'             => 'text',
      'exclude'               => true,
      'eval'                  => array('tl_class'=>'w50'),
      'sql'                   => "varchar(255) NOT NULL default ''"
    ),
    'customer_number_start' => array
    (
      'label'                 => &$GLOBALS['TL_LANG']['tl_li_settings']['customer_number_start'],
      'inputType'             => 'text',
      'exclude'               => true,
      'eval'                  => array('tl_class'=>'w50', 'rgxp'=>'digit'),
      'sql'                   => "int(10) unsigned NOT NULL default '0'"
    ),
    'project_number' => array
    (
      'label'                 => &$GLOBALS['TL_LANG']['tl_li_settings']['project_number'],
      'inputType'             => 'text',
      'exclude'               => true,
      'eval'                  => array('tl_class'=>'w50'),
      'sql'                   => "varchar(255) NOT NULL default ''"
    ),
    'project_number_start' => array
    (
      'label'                 => &$GLOBALS['TL_LANG']['tl_li_settings']['project_number_start'],
      'inputType'             => 'text',
      'exclude'               => true,
      'eval'                  => array('tl_class'=>'w50', 'rgxp'=>'digit'),
      'sql'                   => "int(10) unsigned NOT NULL default '0'"
    ),
    'invoice_maturity' => array
    (
      'label'                 => &$GLOBALS['TL_LANG']['tl_li_settings']['invoice_maturity'],
      'inputType'             => 'text',
      'exclude'               => true,
      'eval'                  => array('tl_class'=>'w50', 'mandatory'=>true),
      'sql'                   => "varchar(255) NOT NULL default ''"
    ),
    'invoice_number' => array
    (
      'label'                 => &$GLOBALS['TL_LANG']['tl_li_settings']['invoice_number'],
      'inputType'             => 'text',
      'exclude'               => true,
      'eval'                  => array('tl_class'=>'w50 clr', 'mandatory'=>true),
      'sql'                   => "varchar(255) NOT NULL default ''"
    ),
    'invoice_number_start' => array
    (
      'label'                 => &$GLOBALS['TL_LANG']['tl_li_settings']['invoice_number_start'],
      'inputType'             => 'text',
      'exclude'               => true,
      'eval'                  => array('tl_class'=>'w50', 'rgxp'=>'digit', 'mandatory'=>true),
      'sql'                   => "int(10) unsigned NOT NULL default '0'"
    ),
    'invoice_reminder_from' => array
    (
      'label'                 => &$GLOBALS['TL_LANG']['tl_li_settings']['invoice_reminder_from'],
      'inputType'             => 'text',
      'exclude'               => true,
      'search'                => true,
      'eval'                  => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50'),
      'sql'                   => "varchar(255) NOT NULL default ''"
    ),
    'invoice_reminder_fromName' => array
    (
      'label'                 => &$GLOBALS['TL_LANG']['tl_li_settings']['invoice_reminder_fromName'],
      'inputType'             => 'text',
      'exclude'               => true,
      'search'                => true,
      'eval'                  => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50'),
      'sql'                   => "varchar(255) NOT NULL default ''"
    ),
    'invoice_reminder_receiver' => array
    (
      'label'                 => &$GLOBALS['TL_LANG']['tl_li_settings']['invoice_reminder_receiver'],
      'inputType'             => 'checkboxWizard',
      'exclude'               => true,
      'foreignKey'            => 'tl_user.username',
      'eval'                  => array('mandatory'=>true, 'multiple'=>true, 'tl_class'=>'clr m12'),
      'sql'                   => "varchar(255) NOT NULL default ''"
    ),    
    'invoice_dispatch_from' => array
    (
      'label'                 => &$GLOBALS['TL_LANG']['tl_li_settings']['invoice_dispatch_from'],
      'inputType'             => 'text',
      'exclude'               => true,
      'search'                => true,
      'eval'                  => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50'),
      'sql'                   => "varchar(255) NOT NULL default ''"
    ),
    'invoice_dispatch_fromName' => array
    (
      'label'                 => &$GLOBALS['TL_LANG']['tl_li_settings']['invoice_dispatch_fromName'],
      'inputType'             => 'text',
      'exclude'               => true,
      'search'                => true,
      'eval'                  => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50'),
      'sql'                   => "varchar(255) NOT NULL default ''"
    ),
    'invoice_template' => array
        (
      'label'                 => &$GLOBALS['TL_LANG']['tl_li_settings']['invoice_template'],
      'inputType'             => 'select',
      'exclude'               => true,
      'options_callback'      => array('LiCRM\InvoiceTemplate', 'getInvoiceTemplates'),
      'eval'                  => array('chosen'=>true, 'tl_class'=>'w50'),
      'sql'                   => "varchar(64) NOT NULL default ''"
    ),
    'logo' => array
    (
      'label'                 => &$GLOBALS['TL_LANG']['tl_li_settings']['logo'],
      'inputType'             => 'fileTree',
      'exclude'               => true,
      'eval'                  => array('mandatory'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr', 'files'=>true, 'filesOnly'=>true),
      'sql'                   => "varchar(255) NOT NULL default ''"
    ),
    'maturity' => array
    (
      'label'                 => &$GLOBALS['TL_LANG']['tl_li_settings']['maturity'],
      'inputType'             => 'text',
      'exclude'               => true,
      'eval'                  => array('tl_class'=>'w50'),
      'sql'                   => "int(10) unsigned NOT NULL default '0'"
    ),
    'descriptionBefore' => array
    (
      'label'                 => &$GLOBALS['TL_LANG']['tl_li_settings']['descriptionBefore'],
      'inputType'             => 'textarea',
      'exclude'               => true,
      'eval'                  => array('rte'=>'tinyMCE', 'tl_class'=>'clr'),
      'sql'                   => "text NOT NULL"
    ),
    'descriptionAfter' => array
    (
      'label'                 => &$GLOBALS['TL_LANG']['tl_li_settings']['descriptionAfter'],
      'inputType'             => 'textarea',
      'exclude'               => true,
      'eval'                  => array('rte'=>'tinyMCE', 'tl_class'=>'clr'),
      'sql'                   => "text NOT NULL"
    ),
    'basePath' => array
    (
      'label'                 => &$GLOBALS['TL_LANG']['tl_li_settings']['basePath'],
      'inputType'             => 'fileTree',
      'exclude'               => true,
      'save_callback'         => array(array('LiCRM\InvoiceTemplate', 'moveHtaccessFile')),
      'eval'                  => array('fieldType'=>'radio', 'tl_class'=>'clr', 'files'=>false, 'mandatory'=>true),
      'sql'                   => "varchar(255) NOT NULL default ''"
    ),
    'periodFolder' => array
    (
      'label'                 => &$GLOBALS['TL_LANG']['tl_li_settings']['periodFolder'],
      'inputType'             => 'select',
      'exclude'               => true,
      'options'               => array('daily', 'weekly', 'monthly', 'yearly'),
      'reference'             => &$GLOBALS['TL_LANG']['tl_li_settings']['periods'],
      'eval'                  => array('includeBlankOption'=>true, 'chosen'=>true),
      'sql'                   => "varchar(10) NOT NULL default ''"
    ),
    'li_crm_task_reminder_from' => array
    (
      'label'                 => &$GLOBALS['TL_LANG']['tl_li_settings']['task_reminder_from'],
      'inputType'             => 'text',
      'exclude'               => true,
      'search'                => true,
      'eval'                  => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50')
    ),
    'li_crm_task_reminder_fromName' => array
    (
      'label'                 => &$GLOBALS['TL_LANG']['tl_li_settings']['task_reminder_fromName'],
      'inputType'             => 'text',
      'exclude'               => true,
      'search'                => true,
      'eval'                  => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50')
    )
  )
);
