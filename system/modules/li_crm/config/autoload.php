<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2013 Leo Feyer
 * 
 * @package Li_crm
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
    'W3S',
));

/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
    'W3S\LiCRM\TaskReminder'              => 'system/modules/li_crm/classes/TaskReminder.php',
	'W3S\LiCRM\Contact'                   => 'system/modules/li_crm/classes/Contact.php',
	'W3S\LiCRM\InvoiceCategory'           => 'system/modules/li_crm/classes/InvoiceCategory.php',
	'W3S\LiCRM\Settings'                  => 'system/modules/li_crm/classes/Settings.php',
	'W3S\LiCRM\InvoiceGeneration'         => 'system/modules/li_crm/classes/InvoiceGeneration.php',
	'W3S\LiCRM\Appointment'               => 'system/modules/li_crm/classes/Appointment.php',
	'W3S\LiCRM\CustomerRegistration'      => 'system/modules/li_crm/classes/CustomerRegistration.php',
	'W3S\LiCRM\Product'                   => 'system/modules/li_crm/classes/Product.php',
    'W3S\LiCRM\Task'                      => 'system/modules/li_crm/classes/Task.php',
    'W3S\LiCRM\ProductType'               => 'system/modules/li_crm/classes/ProductType.php',
    'W3S\LiCRM\ServiceType'               => 'system/modules/li_crm/classes/ServiceType.php',
    'W3S\LiCRM\Invoice'                   => 'system/modules/li_crm/classes/Invoice.php',
    'W3S\LiCRM\WorkPackage'               => 'system/modules/li_crm/classes/WorkPackage.php',
	'W3S\LiCRM\TaskStatus'                => 'system/modules/li_crm/classes/TaskStatus.php',
	'W3S\LiCRM\TaskHistory'               => 'system/modules/li_crm/classes/TaskHistory.php',
	'W3S\LiCRM\Project'                   => 'system/modules/li_crm/classes/Project.php',
	'W3S\LiCRM\HourlyWage'                => 'system/modules/li_crm/classes/HourlyWage.php',
	'W3S\LiCRM\CompanySettings'           => 'system/modules/li_crm/classes/CompanySettings.php',
	'W3S\LiCRM\Customer'                  => 'system/modules/li_crm/classes/Customer.php',
	'W3S\LiCRM\InvoiceReminder'           => 'system/modules/li_crm/classes/InvoiceReminder.php',
	'W3S\LiCRM\Service'                   => 'system/modules/li_crm/classes/Service.php',
	'W3S\LiCRM\TaskComment'               => 'system/modules/li_crm/classes/TaskComment.php',
	'W3S\LiCRM\CustomerList'              => 'system/modules/li_crm/classes/CustomerList.php',
	'W3S\LiCRM\DetailsBox'                => 'system/modules/li_crm/classes/DetailsBox.php',
	'W3S\LiCRM\TaskStatusMessages'        => 'system/modules/li_crm/classes/TaskStatusMessages.php',
	'W3S\LiCRM\Reminder'                  => 'system/modules/li_crm/classes/Reminder.php',
	'W3S\LiCRM\InvoiceTemplate'           => 'system/modules/li_crm/classes/InvoiceTemplate.php',
	'W3S\LiCRM\WorkingHourCalendar'       => 'system/modules/li_crm/classes/WorkingHourCalendar.php',
	'W3S\LiCRM\CurrencyHelper'            => 'system/modules/li_crm/classes/CurrencyHelper.php',

    // Models

    // Modules
    'W3S\LiCRM\ModuleTaskReader'          => 'system/modules/li_crm/modules/ModuleTaskReader.php',
    'W3S\LiCRM\ModuleMobileCustomerList'  => 'system/modules/li_crm/modules/MobileCustomerList.php',
    'W3S\LiCRM\ModuleInvoiceReader'       => 'system/modules/li_crm/modules/ModuleInvoiceReader.php',
	'W3S\LiCRM\ModuleMobileAddressReader' => 'system/modules/li_crm/modules/ModuleMobileAddressReader.php',
    'W3S\LiCRM\ModuleInvoiceList'         => 'system/modules/li_crm/modules/ModuleInvoiceList.php',
    'W3S\LiCRM\ModuleTaskList'            => 'system/modules/li_crm/modules/ModuleTaskList.php',
    'W3S\LiCRM\MemberGroup'               => 'system/modules/li_crm/modules/MemberGroup.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'be_appointment_details'    => 'system/modules/li_crm/templates',
	'be_appointments_day'       => 'system/modules/li_crm/templates',
	'be_appointments_month'     => 'system/modules/li_crm/templates',
	'be_appointments_week'      => 'system/modules/li_crm/templates',
	'be_customer_list'          => 'system/modules/li_crm/templates',
	'be_invoice'                => 'system/modules/li_crm/templates',
	'be_settings'               => 'system/modules/li_crm/templates',
	'be_task'                   => 'system/modules/li_crm/templates',
	'be_task_comment'           => 'system/modules/li_crm/templates',
	'be_working_hour_calendar'  => 'system/modules/li_crm/templates',
	'fe_li_crm_mobile'          => 'system/modules/li_crm/templates',
	'invoice_default'           => 'system/modules/li_crm/templates',
	'mod_invoicelist'           => 'system/modules/li_crm/templates',
	'mod_invoicereader'         => 'system/modules/li_crm/templates',
	'mod_mobile_address_reader' => 'system/modules/li_crm/templates',
	'mod_mobile_customer_list'  => 'system/modules/li_crm/templates',
	'mod_tasklist'              => 'system/modules/li_crm/templates',
	'mod_taskreader'            => 'system/modules/li_crm/templates',
	'nav_li_crm_mobile'         => 'system/modules/li_crm/templates',
));
