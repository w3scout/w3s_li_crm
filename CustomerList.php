<?php
if (!defined('TL_ROOT'))
	die('You cannot access this file directly!');

/**
 * PHP version 5
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @author     apoy2k
 * @license    MIT (see /LICENSE.txt for further information)
 */

/**
 * Class CustomerList
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
		$lang = $GLOBALS['TL_LANG']['li_customers'];
		
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
                        'icon' => !empty($objServices->icon) ? $objServices->icon : 'system/modules/li_crm/icons/service_default.png',
                        'editLabel' => sprintf($lang['serviceEdit'][0], $id),
                        'editTitle' => sprintf($lang['serviceEdit'][1], $id),
                        'copyLabel' => sprintf($lang['serviceCopy'][0], $id),
                        'copyTitle' => sprintf($lang['serviceCopy'][1], $id),
                        'deleteLabel' => sprintf($lang['serviceDelete'][0], $id),
                        'deleteTitle' => sprintf($lang['serviceDelete'][1], $id),
                        'deleteDialog' => sprintf($lang['serviceDelete'][2], $id),
                        'infoLabel' => sprintf($lang['serviceInfo'][0], $id),
                        'infoTitle' => sprintf($lang['serviceInfo'][1], $id)
					);
				}
				
				// Get all products of this project
				$objProducts = $this->Database->prepare("SELECT pp.id, p.title as productTitle, pt.icon
					FROM tl_li_product_to_project AS pp
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
						'icon' => !empty($objProducts->icon) ? $objProducts->icon : 'system/modules/li_crm/icons/products.png',
                        'editTitle' => sprintf($lang['productEdit'][0], $id),
                        'editLabel' => sprintf($lang['productEdit'][1], $id),
                        'copyLabel' => sprintf($lang['productCopy'][0], $id),
                        'copyTitle' => sprintf($lang['productCopy'][1], $id),
                        'deleteLabel' => sprintf($lang['productDelete'][0], $id),
                        'deleteTitle' => sprintf($lang['productDelete'][1], $id),
                        'deleteDialog' => sprintf($lang['productDelete'][2], $id),
                        'infoLabel' => sprintf($lang['productInfo'][0], $id),
                        'infoTitle' => sprintf($lang['productInfo'][1], $id)
					);
				}
                
				$id = $objProjects->id;
				$arrProjects[] = array(
						'id' => $id,
						'projectNumber' => $objProjects->projectNumber,
						'title' => $objProjects->title,
						'editLabel' => sprintf($lang['projectEdit'][0], $id),
						'editTitle' => sprintf($lang['projectEdit'][1], $id),
						'copyLabel' => sprintf($lang['projectCopy'][0], $id),
						'copyTitle' => sprintf($lang['projectCopy'][1], $id),
						'deleteLabel' => sprintf($lang['projectDelete'][0], $id),
						'deleteTitle' => sprintf($lang['projectDelete'][1], $id),
						'deleteDialog' => sprintf($lang['projectDelete'][2], $id),
						'infoLabel' => sprintf($lang['projectInfo'][0], $id),
						'infoTitle' => sprintf($lang['projectInfo'][1], $id),
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
				'editLabel' => sprintf($lang['customerEdit'][0], $id),
				'editTitle' => sprintf($lang['customerEdit'][1], $id),
				'copyLabel' => sprintf($lang['customerCopy'][0], $id),
				'copyTitle' => sprintf($lang['customerCopy'][1], $id),
				'deleteLabel' => sprintf($lang['customerDelete'][0], $id),
				'deleteTitle' => sprintf($lang['customerDelete'][1], $id),
				'deleteDialog' => sprintf($lang['customerDelete'][2], $id),
				'infoLabel' => sprintf($lang['customerInfo'][0], $id),
				'infoTitle' => sprintf($lang['customerInfo'][1], $id),
				'addressesLabel' => sprintf($lang['addressesManage'][0], $id),
				'addressesTitle' => sprintf($lang['addressesManage'][1], $id),
				'contactsLabel' => sprintf($lang['contactsManage'][0], $id),
				'contactsTitle' => sprintf($lang['contactsManage'][1], $id),
				'projects' => $arrProjects,
				'isDisabled' => $objCustomers->disable,
				'display' => $_SESSION['li_crm']['customerList']['customer'][$id]['display']
			);
		}

		$this->Template->customers = $arrCustomers;
		$this->Template->lang = $lang;
        
		return $this->Template->parse();
	}
	
	protected function compile() {}
}
?>