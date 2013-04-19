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
 * Class CustomerList
 */
class CustomerList extends \BackendModule
{
	protected $strTemplate = 'be_customer_list';
	
	public function generate()
	{
		parent::generate();

        // Redirect to another page when element is created
        $key = \Input::get('key');
        $id = \Input::get('id');

        $projectId = \Input::get('projectId') != '' ? \Input::get('projectId') : 0;

        if($key == 'project')
        {
            $projectId = $this->Database->prepare("
                INSERT INTO tl_li_project(tstamp, toCustomer)
                VALUES(?, ?)
            ")->execute(
                time(),
                $id
            )->insertId;

            $this->redirect('contao/main.php?do=li_customers&table=tl_li_project&act=edit&id='.$projectId.'&rt='.REQUEST_TOKEN);
        }
        elseif($key == 'service')
        {
            $serviceId = $this->Database->prepare("
                INSERT INTO tl_li_service(tstamp, toCustomer, toProject)
                VALUES(?, ?, ?)
            ")->execute(
                time(),
                $id,
                $projectId
            )->insertId;

            $this->redirect('contao/main.php?do=li_customers&table=tl_li_service&act=edit&id='.$serviceId.'&rt='.REQUEST_TOKEN);
        }
        elseif($key == 'product')
        {
            $productToCustomerId = $this->Database->prepare("
                INSERT INTO tl_li_product_to_customer(tstamp, toCustomer, toProject)
                VALUES(?, ?, ?)
            ")->execute(
                time(),
                $id,
                $projectId
            )->insertId;

            $this->redirect('contao/main.php?do=li_customers&table=tl_li_product_to_customer&act=edit&id='.$productToCustomerId.'&rt='.REQUEST_TOKEN);
        }

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

        // Filter elements
        // Reset if value = 0
        if(\Input::post('tl_type') == '0')
        {
            $searchType = "";
            $searchValue = "";
        }
        elseif(\Input::post('tl_type') != '')
        {
            $searchType = \Input::post('tl_type');
            $searchValue = \Input::post('tl_value');
        }
        elseif($_SESSION['li_customers']['tl_type'] != '')
        {
            $searchType = $_SESSION['li_customers']['tl_type'];
            $searchValue = $_SESSION['li_customers']['tl_value'];
        }

        $this->Template->searchType = $searchType;
        $this->Template->searchValue = $searchValue;

        $_SESSION['li_customers']['tl_type'] = $searchType;
        $_SESSION['li_customers']['tl_value'] = $searchValue;

        // Workaround for a Contao Bug with LINK in MySQL
        $searchValue = strtoupper($searchValue);

        // Limit elements
        $contaoLimit = $GLOBALS['TL_CONFIG']['resultsPerPage'] != '' ? $GLOBALS['TL_CONFIG']['resultsPerPage'] : 30;
        $objCount = $this->Database->prepare("
            SELECT COUNT(id) AS total
            FROM tl_member
            WHERE isCustomer = 1
        ")->execute();
        $customerTotal = $objCount->total;

        $optionsCount = $customerTotal / $contaoLimit;

        // Reset if value = tl_limit
        if(\Input::post('tl_limit') == 'tl_limit')
        {
            $currentLimit = '0,'.$contaoLimit;
        }
        elseif(\Input::post('tl_limit') == 'all')
        {
            $currentLimit = '0,'.$customerTotal;
        }
        elseif(\Input::post('tl_limit') != '')
        {
            $currentLimit = \Input::post('tl_limit');
        }
        elseif($_SESSION['li_customers']['tl_limit'] != '')
        {
            $currentLimit = $_SESSION['li_customers']['tl_limit'];
        }
        // No limit available
        else
        {
            $currentLimit = '0,'.$contaoLimit;
        }
        // Save current limit
        $_SESSION['li_customers']['tl_limit'] = $currentLimit;

        $this->Template->currentLimit = $currentLimit;

        $sqlLimit = ' LIMIT '.$currentLimit;

        $limitOptions = array();
        // Active element in range
        $rangeActive = false;
        // Reset option
        $limitOptions[] = array
        (
            'value' => 'tl_limit',
            'label' => $GLOBALS['TL_LANG']['MSC']['filterRecords'],
            'active' => false
        );
        // Range options
        for($i = 0; $i < $optionsCount; $i++)
        {
            $startValue = $i * $contaoLimit;
            $endValue = $contaoLimit;
            $startLabel = $i * $contaoLimit + 1;
            $endLabel = ($i+1) * $contaoLimit <= $customerTotal ? ($i+1) * $contaoLimit : $i * $contaoLimit + $customerTotal % $contaoLimit;
            if($startValue.','.$endValue == $currentLimit)
            {
                $active = true;
                $rangeActive = true;
            }
            else
            {
                $active = false;
            }
            $limitOptions[] = array
            (
                'value' => $startValue.','.$endValue,
                'label' => $startLabel.' - '.$endLabel,
                'active' => $startValue.','.$endValue == $currentLimit
            );
        }
        // All option
        $limitOptions[] = array
        (
            'value' => 'all',
            'label' => $GLOBALS['TL_LANG']['MSC']['filterAll'],
            'active' => !$rangeActive
        );
        $this->Template->limitOptions = $limitOptions;

		// Get all valid customers
        if($searchType == 'customer' && !empty($searchValue))
        {
            $objCustomers = $this->Database->prepare("
                SELECT id, customerNumber, customerName, disable
                FROM tl_member
                WHERE isCustomer = 1
                    AND NOT customerNumber = ''
                    AND NOT customerName = ''
                    AND
                    (
                        customerNumber LIKE '%".$searchValue."%'
                        OR customerName LIKE '%".$searchValue."%'
                        OR firstname LIKE '%".$searchValue."%'
                        OR lastname LIKE '%".$searchValue."%'
                        OR email LIKE '%".$searchValue."%'
                    )
                ORDER BY customerNumber ASC
                ".$sqlLimit
            )->execute();
        }
        elseif($searchType == 'project' && !empty($searchValue))
        {
            $objCustomers = $this->Database->prepare("
                SELECT DISTINCT m.id, m.customerNumber, m.customerName, m.disable
                FROM tl_member AS m
                INNER JOIN tl_li_project AS p
                    ON m.id = p.toCustomer
                WHERE m.isCustomer = 1
                    AND NOT m.customerNumber = ''
                    AND NOT m.customerName = ''
                    AND
                    (
                        p.projectNumber LIKE '%".$searchValue."%'
                        OR p.title LIKE '%".$searchValue."%'
                    )
                ORDER BY m.customerNumber ASC
                ".$sqlLimit
            )->execute();
        }
        elseif($searchType == 'service' && !empty($searchValue))
        {
            $objCustomers = $this->Database->prepare("
                SELECT DISTINCT m.id, m.customerNumber, m.customerName, m.disable
                FROM tl_member AS m
                INNER JOIN tl_li_service AS s
                    ON m.id = s.toCustomer
                WHERE m.isCustomer = 1
                    AND NOT m.customerNumber = ''
                    AND NOT m.customerName = ''
                    AND
                    (
                        s.title LIKE '%".$searchValue."%'
                    )
                ORDER BY m.customerNumber ASC
                ".$sqlLimit
            )->execute();
        }
        elseif($searchType == 'product' && !empty($searchValue))
        {
            $objCustomers = $this->Database->prepare("
                SELECT DISTINCT m.id, m.customerNumber, m.customerName, m.disable
                FROM tl_member AS m
                INNER JOIN tl_li_product_to_customer AS pc
                    ON m.id = pc.toCustomer
                INNER JOIN tl_li_product AS p
                    ON pc.toProduct = p.id
                WHERE m.isCustomer = 1
                    AND NOT m.customerNumber = ''
                    AND NOT m.customerName = ''
                    AND
                    (
                        p.title LIKE '%".$searchValue."%'
                    )
                ORDER BY m.customerNumber ASC
                ".$sqlLimit
            )->execute();
        }
        else
        {
            $objCustomers = $this->Database->prepare("
                SELECT id, customerNumber, customerName, disable
                FROM tl_member
                WHERE isCustomer = 1
                    AND NOT customerNumber = ''
                    AND NOT customerName = ''
                ORDER BY customerNumber ASC
                ".$sqlLimit
            )->execute();
        }

		$arrCustomers = array();
		while ($objCustomers->next())
		{
            // Get all services of that customer which aren't connected to a project
            if($searchType == 'service' && !empty($searchValue))
            {
                $objCustomerServices = $this->Database->prepare("
                    SELECT s.id, s.title AS serviceTitle, t.icon
                    FROM tl_li_service AS s
                    LEFT JOIN tl_li_service_type AS t
                        ON s.toServiceType = t.id
                    WHERE s.toProject = 0
                        AND s.toCustomer = ".$objCustomers->id."
                        AND s.title LIKE '%".$searchValue."%'
                    ORDER BY t.orderNumber ASC
                ")->execute();
            }
            elseif($searchType == 'product' && !empty($searchValue))
            {
                $objCustomerServices = null;
            }
            else
            {
                $objCustomerServices = $this->Database->prepare("
                    SELECT s.id, s.title AS serviceTitle, t.icon
                    FROM tl_li_service AS s
                    LEFT JOIN tl_li_service_type AS t
                        ON s.toServiceType = t.id
                    WHERE s.toProject = 0
                        AND s.toCustomer = ?
                    ORDER BY t.orderNumber ASC
                ")->execute($objCustomers->id);
            }
            
            $arrCustomerServices = array();
            if($objCustomerServices != null)
            {
                while ($objCustomerServices->next())
                {
                    $id = $objCustomerServices->id;
                    $arrCustomerServices[] = array
                    (
                        'id' => $id,
                        'serviceTitle' => $objCustomerServices->serviceTitle,
                        'icon' => $objCustomerServices->icon != '' ? $objCustomerServices->icon : 'system/modules/li_crm/assets/service_default.png',
                    );
                }
            }

            // Get all products of this project which aren't connected to a project
            if($searchType == 'product' && !empty($searchValue))
            {
                $objCustomerProducts = $this->Database->prepare("
                    SELECT pp.id, p.title as productTitle, pt.icon
                    FROM tl_li_product_to_customer AS pp
                    INNER JOIN tl_li_product AS p
                        ON pp.toProduct = p.id
                    INNER JOIN tl_li_product_type AS pt
                        ON p.toProductType = pt.id
                    WHERE pp.toCustomer = ".$objCustomers->id."
                        AND pp.toProject = 0
                        AND p.title LIKE '%".$searchValue."%'
                    ORDER BY p.title
                ")->execute();
            }
            elseif($searchType == 'service' && !empty($searchValue))
            {
                $objCustomerProducts = null;
            }
            else
            {
                $objCustomerProducts = $this->Database->prepare("
                    SELECT pp.id, p.title as productTitle, pt.icon
                    FROM tl_li_product_to_customer AS pp
                    INNER JOIN tl_li_product AS p
                        ON pp.toProduct = p.id
                    INNER JOIN tl_li_product_type AS pt
                        ON p.toProductType = pt.id
                    WHERE pp.toCustomer = ?
                        AND pp.toProject = 0
                    ORDER BY p.title
                ")->execute($objCustomers->id);
            }
            $arrCustomerProducts = array();
            if($objCustomerProducts != null)
            {
                while ($objCustomerProducts->next())
                {
                    $id = $objCustomerProducts->id;
                    $arrCustomerProducts[] = array
                    (
                        'id' => $id,
                        'productTitle' => $objCustomerProducts->productTitle,
                        'icon' => $objCustomerProducts->icon != '' ? $objCustomerProducts->icon : 'system/modules/li_crm/assets/products.png',
                    );
                }
            }

			// Get all projects of this customer
            if($searchType == 'project' && !empty($searchValue))
            {
                $objProjects = $this->Database->prepare("
                    SELECT id, projectNumber, title
                    FROM tl_li_project
                    WHERE toCustomer = ".$objCustomers->id."
                        AND (
                            projectNumber LIKE '%".$searchValue."%'
                            OR title LIKE '%".$searchValue."%'
                        )
                    ORDER BY projectNumber ASC
                ")->execute();
            }
            else
            {
                $objProjects = $this->Database->prepare("
                    SELECT id, projectNumber, title
                    FROM tl_li_project
                    WHERE toCustomer = ?
                    ORDER BY projectNumber ASC
                ")->execute($objCustomers->id);
            }
			$arrProjects = array();
            if($objProjects != null)
            {
                while ($objProjects->next())
                {
                    // Get all services of that project
                    if($searchType == 'service' && !empty($searchValue))
                    {
                        $objServices = $this->Database->prepare("
                            SELECT s.id, s.title AS serviceTitle, t.icon
                            FROM tl_li_service AS s
                            LEFT JOIN tl_li_service_type AS t
                                ON s.toServiceType = t.id
                            WHERE s.toProject = ".$objProjects->id."
                                AND s.title LIKE '%".$searchValue."%'
                            ORDER BY t.orderNumber ASC
                         ")->execute();
                    }
                    elseif($searchType == 'product' && !empty($searchValue))
                    {
                        $objServices = null;
                    }
                    else
                    {
                        $objServices = $this->Database->prepare("
                            SELECT p.id, p.title AS serviceTitle, t.icon
                            FROM tl_li_service AS p
                            LEFT JOIN tl_li_service_type AS t
                                ON p.toServiceType = t.id
                            WHERE p.toProject = ?
                            ORDER BY t.orderNumber ASC
                         ")->execute($objProjects->id);
                    }

                    $arrServices = array();
                    if($objServices != null)
                    {
                        while ($objServices->next())
                        {
                            $id = $objServices->id;
                            $arrServices[] = array
                            (
                                'id' => $id,
                                'serviceTitle' => $objServices->serviceTitle,
                                'icon' => $objServices->icon != '' ? $objServices->icon : 'system/modules/li_crm/assets/service_default.png',
                            );
                        }
                    }

                    // Get all products of this project
                    if($searchType == 'product' && !empty($searchValue))
                    {
                        $objProducts = $this->Database->prepare("
                            SELECT pp.id, p.title as productTitle, pt.icon
                            FROM tl_li_product_to_customer AS pp
                                INNER JOIN tl_li_product AS p ON pp.toProduct = p.id
                                INNER JOIN tl_li_product_type AS pt ON p.toProductType = pt.id
                            WHERE pp.toProject = ".$objProjects->id."
                                AND p.title LIKE '%".$searchValue."%'
                            ORDER BY p.title
                        ")->execute();
                    }
                    elseif($searchType == 'service' && !empty($searchValue))
                    {
                        $objProducts = null;
                    }
                    else
                    {
                        $objProducts = $this->Database->prepare("
                            SELECT pp.id, p.title as productTitle, pt.icon
                            FROM tl_li_product_to_customer AS pp
                                INNER JOIN tl_li_product AS p ON pp.toProduct = p.id
                                INNER JOIN tl_li_product_type AS pt ON p.toProductType = pt.id
                            WHERE pp.toProject = ?
                            ORDER BY p.title
                        ")->execute($objProjects->id);
                    }
                    $arrProducts = array();
                    if($objProducts != null)
                    {
                        while ($objProducts->next())
                        {
                            $id = $objProducts->id;
                            $arrProducts[] = array
                            (
                                'id' => $id,
                                'productTitle' => $objProducts->productTitle,
                                'icon' => $objProducts->icon != '' ? $objProducts->icon : 'system/modules/li_crm/assets/products.png',
                            );
                        }
                    }

                    $id = $objProjects->id;
                    $arrProjects[] = array
                    (
                        'id' => $id,
                        'projectNumber' => $objProjects->projectNumber,
                        'title' => $objProjects->title,
                        'services' => $arrServices,
                        'products' => $arrProducts,
                        'display' => $_SESSION['li_crm']['customerList']['project'][$id]['display']
                    );
                }
            }


			$id = $objCustomers->id;
			$arrCustomers[] = array
			(
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
