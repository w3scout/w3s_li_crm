<?php

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @license     MIT (see /LICENSE.txt for further information)
 */

namespace W3S\LiCRM;

/**
 * Class ModuleTaskReader
 */
class ModuleTaskReader extends \Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_taskreader';

	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### TASK READER ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id='.$this->id;

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
		$alias = \Input::get('items');

		$objTask = $this->Database->prepare("
			SELECT t.id, t.title, t.priority, t.deadline, t.description, s.title AS status, s.icon, s.cssClass
			FROM tl_li_task AS t
			INNER JOIN tl_li_task_status AS s
				ON s.id = t.toStatus
			WHERE t.alias = ?
				AND t.published = 1
		")->limit(1)->execute($alias);
		
		if ($objTask->numRows == 1)
		{
			$arrTask = array
			(
					'id'            => $objTask->id,
					'title'         => $objTask->title,
					'priority'      => $objTask->priority,
					'deadline'      => $objTask->deadline,
					'status'        => $objTask->status,
					'description'   => $objTask->description,
					'icon'          => $objTask->icon,
					'cssClass'      => $objTask->cssClass
			);
			$this->Template->task = $arrTask;
			
			$this->Template->taskFound = true;
		}
	}
}