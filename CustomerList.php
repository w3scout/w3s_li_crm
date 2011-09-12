<?php
if (!defined('TL_ROOT'))
	die('You cannot access this file directly!');

/**
 * PHP version 5
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */

/**
 * Class CustomerList
 */
class CustomerList extends BackendModule
{

	/**
	 * Template
	 */
	protected $strTemplate = 'be_customer_list';

	/**
	 * Generate the module
	 * @return string
	 */
	public function generate()
	{
		parent::generate();

		$this->generateCustomerList();

		return $this->Template->parse();
	}

	/**
	 * Generate module
	 */
	protected function compile()
	{

	}

	protected function generateCustomerList()
	{
		$this->loadLanguageFile('li_customer');
		$objCustomers = $this->Database->prepare("SELECT id, customerNumber, customerName, disable FROM tl_member WHERE isCustomer = 1 AND NOT customerNumber = '' AND NOT customerName = '' ORDER BY customerNumber ASC")->execute();
		$arrCustomers = array();
		while ($objCustomers->next())
		{
			$objProjects = $this->Database->prepare("SELECT id, projectNumber, title FROM tl_li_project WHERE toCustomer = ? ORDER BY projectNumber ASC")->execute($objCustomers->id);
			$arrProjects = array();
			while ($objProjects->next())
			{
				$objServices = $this->Database->prepare("SELECT p.id, p.title AS serviceTitle, t.icon FROM tl_li_service AS p INNER JOIN tl_li_service_type AS t ON p.toServiceType = t.id WHERE p.toProject = ? ORDER BY t.orderNumber ASC")->execute($objProjects->id);
				$arrServices = array();
				while ($objServices->next())
				{
					$id = $objServices->id;
					$arrServices[] = array(
							'id' => $id,
							'serviceTitle' => $objServices->serviceTitle,
							'icon' => $objServices->icon != '' ? $objServices->icon : "system/modules/li_crm/icons/service_default.png",
							'editLabel' => sprintf($GLOBALS['TL_LANG']['li_customers']['serviceEdit'][0], $id),
							'editTitle' => sprintf($GLOBALS['TL_LANG']['li_customers']['serviceEdit'][1], $id),
							'copyLabel' => sprintf($GLOBALS['TL_LANG']['li_customers']['serviceCopy'][0], $id),
							'copyTitle' => sprintf($GLOBALS['TL_LANG']['li_customers']['serviceCopy'][1], $id),
							'deleteLabel' => sprintf($GLOBALS['TL_LANG']['li_customers']['serviceDelete'][0], $id),
							'deleteTitle' => sprintf($GLOBALS['TL_LANG']['li_customers']['serviceDelete'][1], $id),
							'deleteDialog' => sprintf($GLOBALS['TL_LANG']['li_customers']['serviceDelete'][2], $id),
							'infoLabel' => sprintf($GLOBALS['TL_LANG']['li_customers']['serviceInfo'][0], $id),
							'infoTitle' => sprintf($GLOBALS['TL_LANG']['li_customers']['serviceInfo'][1], $id)
					);
				}

				$id = $objProjects->id;
				$arrProjects[] = array(
						'id' => $id,
						'projectNumber' => $objProjects->projectNumber,
						'title' => $objProjects->title,
						'editLabel' => sprintf($GLOBALS['TL_LANG']['li_customers']['projectEdit'][0], $id),
						'editTitle' => sprintf($GLOBALS['TL_LANG']['li_customers']['projectEdit'][1], $id),
						'copyLabel' => sprintf($GLOBALS['TL_LANG']['li_customers']['projectCopy'][0], $id),
						'copyTitle' => sprintf($GLOBALS['TL_LANG']['li_customers']['projectCopy'][1], $id),
						'deleteLabel' => sprintf($GLOBALS['TL_LANG']['li_customers']['projectDelete'][0], $id),
						'deleteTitle' => sprintf($GLOBALS['TL_LANG']['li_customers']['projectDelete'][1], $id),
						'deleteDialog' => sprintf($GLOBALS['TL_LANG']['li_customers']['projectDelete'][2], $id),
						'infoLabel' => sprintf($GLOBALS['TL_LANG']['li_customers']['projectInfo'][0], $id),
						'infoTitle' => sprintf($GLOBALS['TL_LANG']['li_customers']['projectInfo'][1], $id),
						'services' => $arrServices
				);
			}

			$id = $objCustomers->id;
			$arrCustomers[] = array(
					'id' => $id,
					'customerNumber' => $objCustomers->customerNumber,
					'customerName' => $objCustomers->customerName,
					'editLabel' => sprintf($GLOBALS['TL_LANG']['li_customers']['customerEdit'][0], $id),
					'editTitle' => sprintf($GLOBALS['TL_LANG']['li_customers']['customerEdit'][1], $id),
					'copyLabel' => sprintf($GLOBALS['TL_LANG']['li_customers']['customerCopy'][0], $id),
					'copyTitle' => sprintf($GLOBALS['TL_LANG']['li_customers']['customerCopy'][1], $id),
					'deleteLabel' => sprintf($GLOBALS['TL_LANG']['li_customers']['customerDelete'][0], $id),
					'deleteTitle' => sprintf($GLOBALS['TL_LANG']['li_customers']['customerDelete'][1], $id),
					'deleteDialog' => sprintf($GLOBALS['TL_LANG']['li_customers']['customerDelete'][2], $id),
					'infoLabel' => sprintf($GLOBALS['TL_LANG']['li_customers']['customerInfo'][0], $id),
					'infoTitle' => sprintf($GLOBALS['TL_LANG']['li_customers']['customerInfo'][1], $id),
					'addressesLabel' => sprintf($GLOBALS['TL_LANG']['li_customers']['addressesManage'][0], $id),
					'addressesTitle' => sprintf($GLOBALS['TL_LANG']['li_customers']['addressesManage'][1], $id),
					'contactsLabel' => sprintf($GLOBALS['TL_LANG']['li_customers']['contactsManage'][0], $id),
					'contactsTitle' => sprintf($GLOBALS['TL_LANG']['li_customers']['contactsManage'][1], $id),
					'projects' => $arrProjects,
					'isDisabled' => $objCustomers->disable
			);
		}

		$this->Template->customers = $arrCustomers;

		$lang = array();
		$lang['customerLabel'] = $GLOBALS['TL_LANG']['li_customers']['customerNew'][0];
		$lang['customerTitle'] = $GLOBALS['TL_LANG']['li_customers']['customerNew'][1];
		$lang['projectLabel'] = $GLOBALS['TL_LANG']['li_customers']['projectNew'][0];
		$lang['projectTitle'] = $GLOBALS['TL_LANG']['li_customers']['projectNew'][1];
		$lang['serviceLabel'] = $GLOBALS['TL_LANG']['li_customers']['serviceNew'][0];
		$lang['serviceTitle'] = $GLOBALS['TL_LANG']['li_customers']['serviceNew'][1];
		$lang['customers'] = $GLOBALS['TL_LANG']['li_customers']['customers'];
		$lang['customer'] = $GLOBALS['TL_LANG']['li_customers']['customer'];
		$lang['noEntries'] = $GLOBALS['TL_LANG']['li_customers']['noEntries'];

		$this->Template->lang = $lang;
	}

}
?>