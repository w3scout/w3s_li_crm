<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */

// Backend modules
array_insert($GLOBALS['BE_MOD'], 0, array
(
    'li_crm' => array
    (
        'li_customers' => array
        (
            'tables'     => array('tl_member', 'tl_li_project', 'tl_li_service', 'tl_li_product_to_customer'),
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
            'callback'   => 'Task',
            'icon'       => 'system/modules/li_crm/icons/tasks.png',
            'stylesheet' => 'system/modules/li_crm/css/crm.css'
        ),
        'li_timekeeping' => array
        (
            'tables'     => array('tl_li_work_package', 'tl_li_working_hour'),
            'callback'   => 'WorkingHourCalendar',
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
            'tables'	 => array('tl_li_customer_settings', 'tl_li_project_settings', 'tl_li_service_type',
				'tl_li_product_type', 'tl_li_task_status', 'tl_li_invoice_settings', 'tl_li_invoice_category',
				'tl_li_invoice_reminder_settings', 'tl_li_invoice_dispatch_settings', 'tl_li_invoice_template',
                'tl_li_task_reminder_settings', 'tl_li_company_settings', 'tl_li_timekeeping_settings', 'tl_li_hourly_wage',
                'tl_li_tax'),
            'callback'	 => 'Settings',
            'icon'       => 'system/modules/li_crm/icons/settings.png',
            'stylesheet' => 'system/modules/li_crm/css/crm.css'
        )
    )
));

// Front end modules
array_insert($GLOBALS['FE_MOD'], 2, array
(
	'li_crm' => array
	(
		'tasklist'      => 'ModuleTaskList',
		'taskreader'    => 'ModuleTaskReader',
		'invoicelist'   => 'ModuleInvoiceList',
		'invoicereader' => 'ModuleInvoiceReader'
	)
));

// Add customer fields to members
$GLOBALS['BE_MOD']['accounts']['member']['tables'][] = 'tl_li_contact';

// Delete callbacks if a specific table is set. This way,
// the callbacks are only used when the overview screen is requested
if ($_GET['do'] == 'li_customers' && !empty($_GET['table']))
{
	unset($GLOBALS['BE_MOD']['li_crm']['li_customers']['callback']);
}
if ($_GET['do'] == 'li_tasks' && empty($_GET['key']))
{
	unset($GLOBALS['BE_MOD']['li_crm']['li_tasks']['callback']);
}
if ($_GET['do'] == 'li_invoices' && empty($_GET['key']))
{
	unset($GLOBALS['BE_MOD']['li_crm']['li_invoices']['callback']);
}
if ($_GET['do'] == 'li_settings' && !empty($_GET['table']))
{
	unset($GLOBALS['BE_MOD']['li_crm']['li_settings']['callback']);
}
if ($_GET['do'] == 'li_timekeeping' && !empty($_GET['table']))
{
	unset($GLOBALS['BE_MOD']['li_crm']['li_timekeeping']['callback']);
}

// Reminder cronjob
$GLOBALS['TL_CRON']['daily'][]  = array('Reminder', 'checkForReminder');  

// Hooks
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('Customer', 'getCustomerCount');
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('Project', 'getProjectCount');
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('Invoice', 'getInvoiceCount');

$GLOBALS['TL_HOOKS']['executePostActions'][] = array('Invoice', 'generateInvoice');
