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
			if (isset($arrSplit[1]) && is_numeric($arrSplit[1]))
			{
				$objCustomer = $this->Database->prepare("SELECT COUNT(id) AS count
				    FROM tl_member
				    WHERE isCustomer = '1'")->limit(1)->execute();
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
		$objCustomers = $this->Database->prepare("SELECT id, customerNumber, customerName
											      FROM tl_member
											      WHERE disable = ''
											      	AND isCustomer = '1'")->execute();

		$customers = array();
		while ($objCustomers->next())
		{
			$customers[$objCustomers->id] = $objCustomers->customerNumber." ".$objCustomers->customerName;
		}
		return $customers;
	}

	public function getCustomerWithProjectsOptions(DataContainer $dc)
	{
		$customers = array();

		$objCustomers = $this->Database->prepare("SELECT id, customerNumber, customerName
		    FROM tl_member AS m
		    WHERE disable = ''
		        AND (SELECT COUNT(p.id)
		            FROM tl_li_project AS p
		            WHERE p.toCustomer = m.id
		        ) > 0")->execute();

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
		return $this->replaceInsertTags($GLOBALS['TL_CONFIG']['li_crm_customer_number_generation']);
		;
	}

    public function changeMandatoryFields(DataContainer $dc) {
            if($dc->activeRecord == null) {
                $objMember = $this->Database->prepare("
                    SELECT isCustomer
                    FROM tl_member
                    WHERE id = ?
                ")->limit(1)->execute($dc->id);
                $isCustomer = $objMember->isCustomer;
            } else {
                $isCustomer = $dc->activeRecord->isCustomer;
            }

            if($isCustomer) {
                $GLOBALS['TL_DCA']['tl_member']['fields']['gender']['eval']['mandatory'] = true;
                $GLOBALS['TL_DCA']['tl_member']['fields']['street']['eval']['mandatory'] = true;
                $GLOBALS['TL_DCA']['tl_member']['fields']['postal']['eval']['mandatory'] = true;
                $GLOBALS['TL_DCA']['tl_member']['fields']['city']['eval']['mandatory'] = true;
                $GLOBALS['TL_DCA']['tl_member']['fields']['country']['eval']['mandatory'] = true;
                $GLOBALS['TL_DCA']['tl_member']['fields']['language']['eval']['mandatory'] = true;
            }
    }

    public function updateDefaultAddress(DataContainer $dc) {
        $objAddress = $this->Database->prepare("
            SELECT id
            FROM tl_address
            WHERE pid = ?
                AND isDefaultAddress = 1
        ")->limit(1)->execute($dc->id);
        if($objAddress->numRows == 1) {
            // Default address available
            $this->Database->prepare("
                UPDATE tl_address
                SET firstname = ?, lastname = ?, gender = ?, language = ?,
                    company = ?, street = ?, street_2 = ?, street_3 = ?, postal = ?, city = ?, state = ?, country = ?,
                    email = ?, secondEmail = ?, phone = ?, mobile = ?, fax = ?, website = ?
            ")->execute(
                $dc->activeRecord->firstname,
                $dc->activeRecord->lastname,
                $dc->activeRecord->gender,
                $dc->activeRecord->language,
                $dc->activeRecord->company != null ? $dc->activeRecord->company : '',
                $dc->activeRecord->street,
                $dc->activeRecord->street_2 != null ? $dc->activeRecord->street_2 : '',
                $dc->activeRecord->street_3 != null ? $dc->activeRecord->street_3 : '',
                $dc->activeRecord->postal,
                $dc->activeRecord->city,
                $dc->activeRecord->state != null ? $dc->activeRecord->state : '',
                $dc->activeRecord->country,
                $dc->activeRecord->email,
                $dc->activeRecord->secondEmail != null ? $dc->activeRecord->secondEmail : '',
                $dc->activeRecord->phone != null ? $dc->activeRecord->phone : '',
                $dc->activeRecord->mobile != null ? $dc->activeRecord->mobile : '',
                $dc->activeRecord->fax != null ? $dc->activeRecord->fax : '',
                $dc->activeRecord->website != null ? $dc->activeRecord->website : ''
            );
        } else {
            // No default address available
            $this->Database->prepare("
                INSERT INTO tl_address (pid, firstname, lastname, gender, language,
                  company, street, street_2, street_3, postal, city, state, country,
                  email, secondEmail, phone, mobile, fax, website, isDefaultAddress)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)
            ")->execute(
                $dc->activeRecord->id,
                $dc->activeRecord->firstname,
                $dc->activeRecord->lastname,
                $dc->activeRecord->gender,
                $dc->activeRecord->language,
                $dc->activeRecord->company != null ? $dc->activeRecord->company : '',
                $dc->activeRecord->street,
                $dc->activeRecord->street_2 != null ? $dc->activeRecord->street_2 : '',
                $dc->activeRecord->street_3 != null ? $dc->activeRecord->street_3 : '',
                $dc->activeRecord->postal,
                $dc->activeRecord->city,
                $dc->activeRecord->state != null ? $dc->activeRecord->state : '',
                $dc->activeRecord->country,
                $dc->activeRecord->email,
                $dc->activeRecord->secondEmail != null ? $dc->activeRecord->secondEmail : '',
                $dc->activeRecord->phone != null ? $dc->activeRecord->phone : '',
                $dc->activeRecord->mobile != null ? $dc->activeRecord->mobile : '',
                $dc->activeRecord->fax != null ? $dc->activeRecord->fax : '',
                $dc->activeRecord->website != null ? $dc->activeRecord->website : ''
            );
        }
    }

}
?>