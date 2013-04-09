<?php

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>, Darko Selesi <hallo@w3scouts.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace W3S\LiCRM;

/**
 * Class CustomerRegistration
 */
class CustomerRegistration extends \Frontend
{
	public function createNewUser($intId, $arrData)
	{
		global $objPage;
		
		// Search the correct registration module
		$objRegistration = $this->Database->prepare("
		    SELECT isCustomer
		    FROM tl_module
		    WHERE id IN
		        (
                    SELECT c.module
                    FROM tl_content AS c
                    WHERE type = 'module'
                        AND c.pid IN
                            (
                                SELECT a.id
                                FROM tl_article AS a
                                WHERE a.pid = ?
                            )
                )
		")->limit(1)->execute($objPage->id);
		
		// Update isCustomer field
        if($objRegistration->isCustomer) {

            // Update member to customer for the customer number
            $this->Database->prepare("
                UPDATE tl_member
                SET isCustomer = 1
                WHERE id = ?
            ")->execute(
                $intId
            );

            // Create customer number and name
            $customerNumber = $this->replaceInsertTags($GLOBALS['TL_CONFIG']['li_crm_customer_number_generation']);
            $customerName = $arrData['company'] != '' ? $arrData['company'] : $arrData['firstname']." ".$arrData['lastname'];

            $this->Database->prepare("
                UPDATE tl_member
                SET customerNumber = ?,
                    customerName = ?
                WHERE id = ?
            ")->execute(
                $customerNumber,
                $customerName,
                $intId
            );
            
            // Add address to user
            $this->Database->prepare("
                INSERT INTO tl_address (pid, firstname, lastname, gender, language,
                  company, street, street_2, street_3, postal, city, state, country,
                  email, secondEmail, phone, mobile, fax, website, isDefaultAddress, isBillingAddress)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, 1)
            ")->execute(
                $intId,
                $arrData['firstname'] != null ? $arrData['firstname'] : '',
                $arrData['lastname'] != null ? $arrData['lastname'] : '',
                $arrData['gender'] != null ? $arrData['gender'] : '',
                $arrData['language'] != null ? $arrData['language'] : '',
                $arrData['company'] != null ? $arrData['company'] : '',
                $arrData['street'] != null ? $arrData['street'] : '',
                $arrData['street_2'] != null ? $arrData['street_2'] : '',
                $arrData['street_3'] != null ? $arrData['street_3'] : '',
                $arrData['postal'] != null ? $arrData['postal'] : '',
                $arrData['city'] != null ? $arrData['city'] : '',
                $arrData['state'] != null ? $arrData['state'] : '',
                $arrData['country'] != null ? $arrData['country'] : '',
                $arrData['email'] != null ? $arrData['email'] : '',
                $arrData['secondEmail'] != null ? $arrData['secondEmail'] : '',
                $arrData['phone'] != null ? $arrData['phone'] : '',
                $arrData['mobile'] != null ? $arrData['mobile'] : '',
                $arrData['fax'] != null ? $arrData['fax'] : '',
                $arrData['website'] != null ? $arrData['website'] : ''
            );

            // Add products to user
            if($arrData['registerProducts'] != null)
            {
                //$products = unserialize($arrData['registerProducts']);
                $products = $arrData['registerProducts'];
                foreach($products as $product)
                {
                    $this->Database->prepare("
                        INSERT INTO tl_li_product_to_customer(tstamp, toCustomer, toProduct)
                        VALUES(?, ?, ?)
                    ")->execute(
                        time(),
                        $intId,
                        $product
                    );
                }
            }

            // Add product to user
            if($arrData['registerProduct'] != null)
            {
                //$products = unserialize($arrData['registerProducts']);
                $product = $arrData['registerProduct'];
                $this->Database->prepare("
                    INSERT INTO tl_li_product_to_customer(tstamp, toCustomer, toProduct)
                    VALUES(?, ?, ?)
                ")->execute(
                    time(),
                    $intId,
                    $product
                );
            }
        }
	}
}
