<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @license     MIT (see /LICENSE.txt for further information)
 */

/**
 * Class ModuleTaskList
 */
class ModuleTaskList extends Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_tasklist';

	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### TASK LIST ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		return parent::generate();
	}


	/**
	 * Generate module
	 */
	protected function compile()
	{
		$this->loadLanguageFile('tl_li_task');
		$this->import('FrontendUser', 'User');
		if($this->User->id != 0) {
			$objTasks = $this->Database->prepare('SELECT t.id, t.title, t.alias, t.priority, t.deadline, s.title AS status, s.icon, s.cssClass
												  FROM tl_li_task AS t
												  INNER JOIN tl_li_task_status AS s ON s.id = t.toStatus
												  WHERE t.toCustomer = ? AND t.published = 1
												  ORDER BY t.priority ASC')->execute($this->User->id);
		} else {
			$objTasks = $this->Database->execute('SELECT t.id, t.title, t.alias, t.priority, t.deadline, s.title AS status, s.icon, s.cssClass
												  FROM tl_li_task AS t
												  INNER JOIN tl_li_task_status AS s ON s.id = t.toStatus
												  WHERE t.published = 1
												  ORDER BY t.priority ASC');
		}
		
		$objPage = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE id=?")
								  ->limit(1)
								  ->execute($this->jumpTo);
		$arrTasks = array();
		while($objTasks->next() != null) {
			$newArray = array(
				'id' => $objTasks->id,
				'title' => $objTasks->title,
				'priority' => $objTasks->priority,
				'deadline' => $objTasks->deadline,
				'status' => $objTasks->status,
				'icon' => $objTasks->icon,
				'cssClass' => $objTasks->cssClass,
				'details' => $this->generateFrontendUrl($objPage->row(), '/items/'. $objTasks->alias)
			);
			$arrTasks[] = $newArray;
		}
		
		$this->Template->user = $this->User;
		$this->Template->tasks = $arrTasks;
	}
}

?>