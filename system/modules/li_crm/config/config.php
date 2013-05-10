<?php

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @author      Tristan Lins <tristan.lins@infinitysoft.de>
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
            'callback'   => 'LiCRM\CustomerList',
            'icon'       => 'system/modules/li_crm/assets/customers.png',
            'stylesheet' => 'system/modules/li_crm/assets/crm.css'
        ),
        /*
        'li_projects' => array
        (
            'tables'     => array('tl_li_project', 'tl_li_task'),
            //'callback'   => 'LiCRM\Task',
            'icon'       => 'system/modules/li_crm/assets/projects.png',
            'stylesheet' => 'system/modules/li_crm/assets/crm.css'
        ),
        */
        'li_tasks' => array
        (
            'tables'     => array('tl_li_task', 'tl_li_task_comment', 'tl_li_task_reminder'),
            'callback'   => 'LiCRM\Task',
            'icon'       => 'system/modules/li_crm/assets/tasks.png',
            'stylesheet' => 'system/modules/li_crm/assets/crm.css',
	        'javascript' => 'system/modules/li_crm/js/Task.js'
        ),
        'li_appointments' => array
        (
            'tables'     => array('tl_li_appointment'),
            'callback'   => 'LiCRM\Appointment',
            'icon'       => 'system/modules/li_crm/assets/appointments.png',
            'stylesheet' => 'system/modules/li_crm/assets/crm.css'
        ),
        'li_timekeeping' => array
        (
            'tables'     => array('tl_li_work_package', 'tl_li_working_hour'),
            'callback'   => 'LiCRM\WorkingHourCalendar',
            'icon'       => 'system/modules/li_crm/assets/timekeeping.png',
            'stylesheet' => 'system/modules/li_crm/assets/crm.css'
        ),
        'li_products' => array
        (
            'tables'     => array('tl_li_product', 'tl_li_product_type'),
            'icon'       => 'system/modules/li_crm/assets/products.png',
            'stylesheet' => 'system/modules/li_crm/assets/crm.css'
        ),
        'li_invoices' => array
        (
            'tables'     => array('tl_li_invoice', 'tl_li_invoice_reminder', 'tl_li_invoice_generation'),
            'callback'   => 'LiCRM\Invoice',
            'icon'       => 'system/modules/li_crm/assets/invoices.png',
            'stylesheet' => 'system/modules/li_crm/assets/crm.css'
        ),
        'li_settings' => array
        (
            'tables'	 => array('tl_li_customer_settings', 'tl_li_project_settings', 'tl_li_service_type',
				'tl_li_product_type', 'tl_li_task_status', 'tl_li_invoice_settings', 'tl_li_invoice_category',
				'tl_li_invoice_reminder_settings', 'tl_li_invoice_dispatch_settings', 'tl_li_invoice_template',
                'tl_li_task_reminder_settings', 'tl_li_company_settings', 'tl_li_timekeeping_settings', 'tl_li_hourly_wage',
                'tl_li_tax'),
            'callback'	 => 'LiCRM\Settings',
            'icon'       => 'system/modules/li_crm/assets/settings.png',
            'stylesheet' => 'system/modules/li_crm/assets/crm.css'
        )
    )
));

// Front end modules
array_insert($GLOBALS['FE_MOD'], 2, array
(
	'li_crm' => array
	(
        'tasklist'              => 'LiCRM\ModuleTaskList',
        'taskreader'            => 'LiCRM\ModuleTaskReader',
        'invoicelist'           => 'LiCRM\ModuleInvoiceList',
        'invoicereader'         => 'LiCRM\ModuleInvoiceReader',
        'mobilecustomerlist'    => 'LiCRM\ModuleMobileCustomerList',
        'mobileaddressreader'   => 'LiCRM\ModuleMobileAddressReader'
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
if ($_GET['do'] == 'li_appointments' && !empty($_GET['table']))
{
	unset($GLOBALS['BE_MOD']['li_crm']['li_appointments']['callback']);
}
if ($_GET['do'] == 'li_timekeeping' && !empty($_GET['table']))
{
	unset($GLOBALS['BE_MOD']['li_crm']['li_timekeeping']['callback']);
}
if ($_GET['do'] == 'li_invoices' && empty($_GET['key']))
{
	unset($GLOBALS['BE_MOD']['li_crm']['li_invoices']['callback']);
}
if ($_GET['do'] == 'li_settings' && !empty($_GET['table']))
{
	unset($GLOBALS['BE_MOD']['li_crm']['li_settings']['callback']);
}

// constant for system log category
define('TL_LICRM','LiCRM');

// Cronjobs

// - Reminder
$GLOBALS['TL_CRON']['daily'][]  = array('LiCRM\Reminder', 'checkForReminder');

// - Invoice generation
$GLOBALS['TL_CRON']['daily'][]  = array('LiCRM\InvoiceGeneration', 'generateInvoices');

// Hooks
// - Replace insert tags
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('LiCRM\Customer', 'getCustomerCount');
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('LiCRM\Project', 'getProjectCount');
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('LiCRM\Invoice', 'getInvoiceCount');

// - Registration
$GLOBALS['TL_HOOKS']['createNewUser'][] = array('LiCRM\CustomerRegistration', 'createNewUser');

// - Rre actions
$GLOBALS['TL_HOOKS']['executePreActions'][] = array('LiCRM\TaskComment', 'hookExecutePreActions');

// - Post actions
$GLOBALS['TL_HOOKS']['executePostActions'][] = array('LiCRM\Invoice', 'generateInvoice');

// - System messsages
$GLOBALS['TL_HOOKS']['getSystemMessages'][] = array('LiCRM\TaskStatusMessages', 'listTasks');

// Form fields
$GLOBALS['BE_FFL']['TaskHistory'] = 'LiCRM\TaskHistory';

$GLOBALS['TL_PERMISSIONS'][] = 'licrm_invoicep';
