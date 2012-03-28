<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @license     MIT (see /LICENSE.txt for further information)
 */

class CustomerRegistration extends Frontend
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

            if($arrData['registerProducts'] != null) {
                //$products = unserialize($arrData['registerProducts']);
                $products = $arrData['registerProducts'];
                foreach($products as $product) {
                    $this->Database->prepare("
                        INSERT INTO tl_li_product_to_customer(tstamp, toCustomer, toProject, toProduct)
                        VALUES(?, ?, ?, ?)
                    ")->execute(
                        time(),
                        $intId,
                        0,
                        $product
                    );
                }
            }
        }
	}
}

?>