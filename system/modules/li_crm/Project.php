<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */

/**
 * Class Project
 */
class Project extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
	}

    public function getProjectsOfCustomer($dc)
    {
        $projectsList = array();

        $getProjects = $this->Database->prepare("
        	SELECT id, projectNumber, title
            FROM tl_li_project
            WHERE toCustomer = ?
            	AND NOT title = ''
            ORDER BY projectNumber ASC")->execute($dc->activeRecord->toCustomer);
        while($getProjects->next())
        {
            $projectsList[$getProjects->id] = $getProjects->projectNumber.' '.$getProjects->title;
        }

        return $projectsList;
    }

    public function getProjectsByCustomerList()
    {
        $projectsList = array();
        
        $getProjects = $this->Database->prepare("
        	SELECT p.id, p.projectNumber, p.title, c.customerName, c.customerNumber
            FROM tl_li_project AS p
            INNER JOIN tl_member AS c
            	ON p.toCustomer = c.id
            WHERE NOT p.title = ''
            ORDER BY customerNumber ASC, projectNumber ASC")->execute();
		
        while($getProjects->next())
        {
            $projectsList[$getProjects->customerNumber.' '.$getProjects->customerName][$getProjects->id] =
                $getProjects->projectNumber.' '.$getProjects->title;
        }
        
        return $projectsList;
    }
    
	public function getProjectCount($insertConfig)
	{
		$arrSplit = explode('::', $insertConfig);

		if ($arrSplit[0] == 'countProjects')
		{
			if (isset($arrSplit[1]))
			{
				$objProject = $this->Database->prepare("
					SELECT COUNT(id) AS count
                    FROM tl_li_project
                ")->limit(1)->executeUncached();
                
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
    
	public function getProjectsFromCustomerOptions($dc)
	{
		$projects = array();
		$cid = $dc->activeRecord->toCustomer;
		if ($cid == 0)
		{
			$projects[0] = "-";
			return $projects;
		}

		$objProjects = $this->Database->prepare("
			SELECT id, projectNumber, title
           	FROM tl_li_project
           	WHERE toCustomer = ?
           		AND NOT title = ''
           	ORDER BY projectNumber ASC
        ")->execute($cid);

		while ($objProjects->next())
		{
			$projects[$objProjects->id] = $objProjects->projectNumber." - ".$objProjects->title;
		}
		return $projects;
	}
    
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
