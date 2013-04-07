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
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'TaskReminder'              => 'system/modules/li_crm/classes/TaskReminder.php',
	'Contact'                   => 'system/modules/li_crm/classes/Contact.php',
	'ModuleInvoiceReader'       => 'system/modules/li_crm/modules/ModuleInvoiceReader.php',
	'InvoiceCategory'           => 'system/modules/li_crm/classes/InvoiceCategory.php',
	'Settings'                  => 'system/modules/li_crm/classes/Settings.php',
	'InvoiceGeneration'         => 'system/modules/li_crm/classes/InvoiceGeneration.php',
	'Appointment'               => 'system/modules/li_crm/classes/Appointment.php',
	'CustomerRegistration'      => 'system/modules/li_crm/classes/CustomerRegistration.php',
	'Product'                   => 'system/modules/li_crm/classes/Product.php',
	'ModuleMobileCustomerList'  => 'system/modules/li_crm/modules/MobileCustomerList.php',
	'TaskStatus'                => 'system/modules/li_crm/classes/TaskStatus.php',
	'TaskHistory'               => 'system/modules/li_crm/classes/TaskHistory.php',
	'Project'                   => 'system/modules/li_crm/classes/Project.php',
	'HourlyWage'                => 'system/modules/li_crm/classes/HourlyWage.php',
	'ModuleInvoiceList'         => 'system/modules/li_crm/modules/ModuleInvoiceList.php',
	'CompanySettings'           => 'system/modules/li_crm/classes/CompanySettings.php',
	'Customer'                  => 'system/modules/li_crm/classes/Customer.php',
	'ModuleTaskReader'          => 'system/modules/li_crm/modules/ModuleTaskReader.php',
	'InvoiceReminder'           => 'system/modules/li_crm/classes/InvoiceReminder.php',
	'Service'                   => 'system/modules/li_crm/classes/Service.php',
	'TaskComment'               => 'system/modules/li_crm/classes/TaskComment.php',
	'CustomerList'              => 'system/modules/li_crm/classes/CustomerList.php',
	'ModuleTaskList'            => 'system/modules/li_crm/modules/ModuleTaskList.php',
	'MemberGroup'               => 'system/modules/li_crm/modules/MemberGroup.php',
	'DetailsBox'                => 'system/modules/li_crm/classes/DetailsBox.php',
	'TaskStatusMessages'        => 'system/modules/li_crm/classes/TaskStatusMessages.php',
	'Reminder'                  => 'system/modules/li_crm/classes/Reminder.php',
	'InvoiceTemplate'           => 'system/modules/li_crm/classes/InvoiceTemplate.php',
	'WorkingHourCalendar'       => 'system/modules/li_crm/classes/WorkingHourCalendar.php',
	'CurrencyHelper'            => 'system/modules/li_crm/classes/CurrencyHelper.php',
	'Task'                      => 'system/modules/li_crm/classes/Task.php',
	'ProductType'               => 'system/modules/li_crm/classes/ProductType.php',
	'ServiceType'               => 'system/modules/li_crm/classes/ServiceType.php',
	'Invoice'                   => 'system/modules/li_crm/classes/Invoice.php',
	'WorkPackage'               => 'system/modules/li_crm/classes/WorkPackage.php',
	'ModuleMobileAddressReader' => 'system/modules/li_crm/modules/ModuleMobileAddressReader.php',
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
