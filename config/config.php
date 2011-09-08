<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * PHP version 5
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */

/**
 * -------------------------------------------------------------------------
 * BACK END MODULES
 * -------------------------------------------------------------------------
 */

array_insert($GLOBALS['BE_MOD'], 0, array
(
    'li_crm' => array
    (
        'li_customers' => array
        (
            'tables'     => array('tl_member', 'tl_li_project', 'tl_li_service'),
            'callback'   => 'CustomerList',
            'icon'       => 'system/modules/li_crm/icons/customers.png',
            'stylesheet' => 'system/modules/li_crm/css/crm.css'
        ),
        'li_products' => array
        (
            'tables'     => array('tl_li_product', 'tl_li_product_type'),
            'icon'       => 'system/modules/li_crm/icons/products.png',
            'stylesheet' => 'system/modules/li_crm/css/crm.css'
        ),
        'li_tasks' => array
        (
            'tables'     => array('tl_li_task', 'tl_li_task_reminder'),
            'icon'       => 'system/modules/li_crm/icons/tasks.png',
            'stylesheet' => 'system/modules/li_crm/css/crm.css'
        ),
        'li_timekeeping' => array
        (
            'tables'     => array('tl_li_work_package', 'tl_li_working_hours'),
            'callback'   => 'WorkingHoursCalendar',
            'icon'       => 'system/modules/li_crm/icons/timekeeping.png',
            'stylesheet' => 'system/modules/li_crm/css/crm.css'
        ),
        'li_invoices' => array
        (
            'tables'     => array('tl_li_invoice', 'tl_li_invoice_reminder'),
            'callback'   => 'Invoice',
            'icon'       => 'system/modules/li_crm/icons/invoices.png',
            'stylesheet' => 'system/modules/li_crm/css/crm.css'
        ),
        'li_settings' => array
        (
            'tables'	 => array('tl_li_customer_settings', 'tl_li_project_settings', 'tl_li_service_type', 'tl_li_product_type', 'tl_li_task_status', 'tl_li_invoice_settings', 'tl_li_invoice_category', 'tl_li_invoice_reminder_settings', 'tl_li_invoice_template', 'tl_li_task_reminder_settings', 'tl_li_company_settings'),
            'callback'	 => 'Settings',
            'icon'       => 'system/modules/li_crm/icons/settings.png',
            'stylesheet' => 'system/modules/li_crm/css/crm.css'
        )
    )
));

$GLOBALS['BE_MOD']['accounts']['member']['tables'][] = 'tl_li_contact';

// Callback is only used for overview screen
if ($_GET['do'] == 'li_customers' && strlen($_GET['table']))
{
	unset($GLOBALS['BE_MOD']['li_crm']['li_customers']['callback']);
}
if ($_GET['do'] == 'li_invoices' && !strlen($_GET['key']))
{
	unset($GLOBALS['BE_MOD']['li_crm']['li_invoices']['callback']);
}
if ($_GET['do'] == 'li_settings' && strlen($_GET['table']))
{
	unset($GLOBALS['BE_MOD']['li_crm']['li_settings']['callback']);
}
if ($_GET['do'] == 'li_timekeeping' && strlen($_GET['table']))
{
	unset($GLOBALS['BE_MOD']['li_crm']['li_timekeeping']['callback']);
}

$GLOBALS['TL_CRON']['daily'][]  = array('Reminder', 'checkForReminder');  

/**
 * -------------------------------------------------------------------------
 * HOOKS
 * -------------------------------------------------------------------------
 */

$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('Customer', 'getCustomerCount');
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('Project', 'getProjectCount');
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('Invoice', 'getInvoiceCount');

$GLOBALS['TL_HOOKS']['executePostActions'][] = array('Invoice', 'generateInvoice');
 
?>