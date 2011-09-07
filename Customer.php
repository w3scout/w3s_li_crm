<?php
if (!defined('TL_ROOT'))
	die('You cannot access this file directly!');

/**
 * PHP version 5
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */

class Customer extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
	}

	public function getCustomerCount($insertConfig)
	{
		$arrSplit = explode('::', $insertConfig);

		if ($arrSplit[0] == 'countCustomers')
		{
			if (isset($arrSplit[1]))
			{
				$objCustomer = $this->Database->prepare("SELECT COUNT(id) AS count FROM tl_member WHERE isCustomer = '1'")->limit(1)->execute();
				$count = $objCustomer->count;
				if (!empty($GLOBALS['TL_CONFIG']['li_crm_customer_number_generation_start']))
				{
					$count += $GLOBALS['TL_CONFIG']['li_crm_customer_number_generation_start'];
				}
				return str_pad($count, $arrSplit[1], '0', STR_PAD_LEFT);
			}
			return false;
		}
		return false;
	}

	public function getCustomerOptions(DataContainer $dc)
	{
		$customers = array();
		$objCustomers = $this->Database->prepare("SELECT id, customerNumber, customerName FROM tl_member WHERE disable = '' AND isCustomer = '1'")->execute();
		while ($objCustomers->next())
		{
			$customers[$objCustomers->id] = $objCustomers->customerNumber." ".$objCustomers->customerName;
		}
		return $customers;
	}

	public function getCustomerWithProjectsOptions(DataContainer $dc)
	{
		$customers = array();
		$objCustomers = $this->Database->prepare("SELECT id, customerNumber, customerName FROM tl_member AS m WHERE disable = '' AND (SELECT COUNT(p.id) FROM tl_li_project AS p WHERE p.toCustomer = m.id ) > 0")->execute();
		while ($objCustomers->next())
		{
			$customers[$objCustomers->id] = $objCustomers->customerNumber." ".$objCustomers->customerName;
		}
		return $customers;
	}

	public function createNewCustomerNumber($value, $dc)
	{
		// Do not create a number if a number is allready set
		if ($value != '')
		{
			return $value;
		}

		// Do not create a number if generation string is not set
		if ($GLOBALS['TL_CONFIG']['li_crm_customer_number_generation'] == '')
		{
			return $value;
		}

		// Generate new customer number
		$value = $this->replaceInsertTags($GLOBALS['TL_CONFIG']['li_crm_customer_number_generation']);
		return $value;
	}

}
?>