<?php
if (!defined('TL_ROOT'))
	die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      apoy2k
 * @license     MIT (see /LICENSE.txt for further information)
 */
class Project extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
	}
    
    /**
     * Returns an array that can be used to create a select-list with all projects, grouped by the customers
     * 
     * @return array All projects grouped by customers
     */
    public function getProjectsByCustomerList()
    {
        $projectsList = array();
        
        $getProjects = $this->Database->prepare("SELECT p.id, p.projectNumber, p.title, c.customerName, c.customerNumber
            FROM tl_li_project AS p
                INNER JOIN tl_member AS c ON p.toCustomer = c.id
            ORDER BY customerNumber ASC, projectNumber ASC")->execute();
        while($getProjects->next())
        {
            $projectsList[$getProjects->customerNumber.' '.$getProjects->customerName][$getProjects->id] =
                $getProjects->projectNumber.' '.$getProjects->title;
        }
        
        return $projectsList;
    }
    
    /**
     * Returns the amount of projects padded with the amount of zeroes defined in the insert tag
     * 
     * @param string $insertConfig The insert tag string
     * @return string The amount of projects
     */
	public function getProjectCount($insertConfig)
	{
		$arrSplit = explode('::', $insertConfig);

		if ($arrSplit[0] == 'countProjects')
		{
			if (isset($arrSplit[1]))
			{
				$objProject = $this->Database->prepare("SELECT COUNT(id) AS count
                    FROM tl_li_project")->limit(1)->execute();
                
				$count = $objProject->count;
				if (!empty($GLOBALS['TL_CONFIG']['li_crm_project_number_generation_start']))
				{
					$count += $GLOBALS['TL_CONFIG']['li_crm_project_number_generation_start'];
				}
				return str_pad($count, $arrSplit[1], '0', STR_PAD_LEFT);
			}
			return false;
		}
		return false;
	}
    
    /**
     * Gets all projects of a customer provided by a data container form
     * 
     * @param DataContainer $dc The data container provided by the form
     * @return array The projects of the customer
     */
	public function getProjectsFromCustomerOptions($dc)
	{
		$projects = array();
		$cid = $dc->activeRecord->toCustomer;
		if ($cid == 0)
		{
			$projects[0] = "-";
			return $projects;
		}

		$objProjects = $this->Database->prepare("SELECT id, projectNumber, title
           FROM tl_li_project
           WHERE toCustomer = ?
           ORDER BY projectNumber ASC")->execute($cid);

		while ($objProjects->next())
		{
			$projects[$objProjects->id] = $objProjects->projectNumber." - ".$objProjects->title;
		}
		return $projects;
	}
    
    /**
     * Generates a new project number
     * 
     * @param string $value
     * @param DataContainer $dc
     * @return string The new project number
     */
	public function createNewProjectNumber($value, $dc)
	{
		// Do not create a number if a number is allready set
		if ($value != '')
		{
			return $value;
		}

		// Do not create a number if generation string is not set
		if ($GLOBALS['TL_CONFIG']['li_crm_project_number_generation'] == '')
		{
			return $value;
		}

		// Generate new customer number
		$value = $this->replaceInsertTags($GLOBALS['TL_CONFIG']['li_crm_project_number_generation']);
        
		return $value;
	}

}
?>