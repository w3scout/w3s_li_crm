<?php
if (!defined('TL_ROOT'))
	die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */
class CustomerList extends BackendModule
{
	protected $strTemplate = 'be_customer_list';
	
	public function generate()
	{
		parent::generate();

		// If a toggle is requested, modify the array accordingly before displaying the tree
		if (!empty($_REQUEST['toggle']) && !empty($_REQUEST['id']))
		{
			// Set the display property to the negated current value
			$_SESSION['li_crm']['customerList'][$_REQUEST['toggle']][$_REQUEST['id']]['display'] = 
				!(bool)$_SESSION['li_crm']['customerList'][$_REQUEST['toggle']][$_REQUEST['id']]['display'];
			
			// Redirect the user back to the overview
			header('Location: main.php?do=li_customers');
		}
		
		// Load language file for customers
		$this->loadLanguageFile('li_customer');
        $this->loadLanguageFile('tl_member');
        $this->loadLanguageFile('tl_li_project');
        $this->loadLanguageFile('tl_li_service');
        $this->loadLanguageFile('tl_li_product');
        $this->loadLanguageFile('tl_address');

		// Get all valid customers
		$objCustomers = $this->Database->prepare("SELECT id, customerNumber, customerName, disable
			FROM tl_member
			WHERE isCustomer = 1
				AND NOT customerNumber = ''
				AND NOT customerName = ''
			ORDER BY customerNumber ASC")->execute();
		$arrCustomers = array();
		while ($objCustomers->next())
		{
            // Get all services of that customer which aren't connected to a project
            $objCustomerServices = $this->Database->prepare("SELECT s.id, s.title AS serviceTitle, t.icon
                FROM tl_li_service AS s
                    INNER JOIN tl_li_service_type AS t ON s.toServiceType = t.id
                WHERE s.toProject = 0 AND s.toCustomer = ?
                ORDER BY t.orderNumber ASC")->execute($objCustomers->id);
            
            $arrCustomerServices = array();
            while ($objCustomerServices->next())
            {
                $id = $objCustomerServices->id;
                $arrCustomerServices[] = array(
                    'id' => $id,
                    'serviceTitle' => $objCustomerServices->serviceTitle,
                    'icon' => $objCustomerServices->icon != '' ? $objCustomerServices->icon : 'system/modules/li_crm/icons/service_default.png',
                );
            }

            // Get all products of this project
            $objCustomerProducts = $this->Database->prepare("SELECT pp.id, p.title as productTitle, pt.icon
                FROM tl_li_product_to_customer AS pp
                    INNER JOIN tl_li_product AS p ON pp.toProduct = p.id
                    INNER JOIN tl_li_product_type AS pt ON p.toProductType = pt.id
                WHERE pp.toCustomer = ? AND pp.toProject = 0
                ORDER BY p.title")->execute($objCustomers->id);
            $arrCustomerProducts = array();
            while ($objCustomerProducts->next())
            {
                $id = $objCustomerProducts->id;
                $arrCustomerProducts[] = array(
                    'id' => $id,
                    'productTitle' => $objCustomerProducts->productTitle,
                    'icon' => $objCustomerProducts->icon != '' ? $objCustomerProducts->icon : 'system/modules/li_crm/icons/products.png',
                );
            }

			// Get all projects of this customer
			$objProjects = $this->Database->prepare("SELECT id, projectNumber, title
				FROM tl_li_project
				WHERE toCustomer = ?
				ORDER BY projectNumber ASC")->execute($objCustomers->id);
			$arrProjects = array();
			while ($objProjects->next())
			{
				// Get all services of that project
				$objServices = $this->Database->prepare("SELECT p.id, p.title AS serviceTitle, t.icon
					FROM tl_li_service AS p
						INNER JOIN tl_li_service_type AS t ON p.toServiceType = t.id
					WHERE p.toProject = ?
					ORDER BY t.orderNumber ASC")->execute($objProjects->id);

				$arrServices = array();
				while ($objServices->next())
				{
					$id = $objServices->id;
					$arrServices[] = array(
                        'id' => $id,
                        'serviceTitle' => $objServices->serviceTitle,
                        'icon' => $objServices->icon != '' ? $objServices->icon : 'system/modules/li_crm/icons/service_default.png',
					);
				}

				// Get all products of this project
				$objProducts = $this->Database->prepare("SELECT pp.id, p.title as productTitle, pt.icon
					FROM tl_li_product_to_customer AS pp
						INNER JOIN tl_li_product AS p ON pp.toProduct = p.id
						INNER JOIN tl_li_product_type AS pt ON p.toProductType = pt.id
					WHERE pp.toProject = ?
					ORDER BY p.title")->execute($objProjects->id);
				$arrProducts = array();
				while ($objProducts->next())
				{
					$id = $objProducts->id;
					$arrProducts[] = array(
						'id' => $id,
						'productTitle' => $objProducts->productTitle,
						'icon' => $objProducts->icon != '' ? $objProducts->icon : 'system/modules/li_crm/icons/products.png',
					);
				}
                
				$id = $objProjects->id;
				$arrProjects[] = array(
						'id' => $id,
						'projectNumber' => $objProjects->projectNumber,
						'title' => $objProjects->title,
						'services' => $arrServices,
                        'products' => $arrProducts,
						'display' => $_SESSION['li_crm']['customerList']['project'][$id]['display']
				);
			}

			$id = $objCustomers->id;
			$arrCustomers[] = array(
				'id' => $id,
				'customerNumber' => $objCustomers->customerNumber,
				'customerName' => $objCustomers->customerName,
				'projects' => $arrProjects,
                'services' => $arrCustomerServices,
                'products' => $arrCustomerProducts,
				'isDisabled' => $objCustomers->disable,
				'display' => $_SESSION['li_crm']['customerList']['customer'][$id]['display']
			);
		}

		$this->Template->customers = $arrCustomers;

		return $this->Template->parse();
	}
	
	protected function compile() {}
}
?>