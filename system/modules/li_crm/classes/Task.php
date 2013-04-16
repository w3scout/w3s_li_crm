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
 * Class Task
 */
class Task extends \BackendModule
{
	/**
	 * @var TaskComment
	 */
	protected $TaskComment;

	/**
	 * @var BackendUser
	 */
	#protected $User;
	
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'be_task';

	/**
	 * Generate the module
	 * @return string
	 */
	public function generate()
	{
		parent::generate();

		$key = \Input::get('key');
		$id = \Input::get('id');

		if ($key == 'done')
		{
			$this->Template->success = $this->taskDone($id);
		}

		$this->Template->id = $id;
		$this->Template->key = $key;

		return $this->Template->parse();
	}
	
	/**
	 * Generate module
	 */
	protected function compile()
	{
	}

	public function generateAlias($varValue, \DataContainer $dc)
	{
		$autoAlias = false;

		// Generate alias if there is none
		if (!strlen($varValue))
		{
			$autoAlias = true;
			$varValue = standardize($dc->activeRecord->title);
		}

		$objAlias = $this->Database->prepare("SELECT id FROM tl_li_task WHERE alias=?")->execute($varValue);

		// Check whether the news alias exists
		if ($objAlias->numRows > 1 && !$autoAlias)
		{
			throw new \Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
		}

		// Add ID to alias
		if ($objAlias->numRows && $autoAlias)
		{
			$varValue .= '-'.$dc->id;
		}

		return $varValue;
	}

	public function getPriorityOptions($dc)
	{
		$options = array();
		for ($i = 1; $i <= 5; $i++)
		{
			$options[$i] = $GLOBALS['TL_LANG']['tl_li_task']['priority'][0]." ".$i;
		}
		return $options;
	}

	public function taskDone($id)
	{
		$objTaskStatus = $this->Database->prepare("SELECT id
												   FROM tl_li_task_status
												   WHERE isTaskDone = 1")->limit(1)->execute();
		if ($objTaskStatus->numRows == 1)
		{
			$this->Database->prepare("UPDATE tl_li_task
									  SET toStatus = ?
									  WHERE id = ?")->execute($objTaskStatus->id, $id);
			return true;
		}
		else
		{
			return false;
		}
	}

	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
		if (strlen(\Input::get('tid')))
		{
			$this->toggleVisibility(\Input::get('tid'), (\Input::get('state') == 1));
			$this->redirect($this->getReferer());
		}

		$href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);
		if (!$row['published'])
		{
			$icon = 'invisible.gif';
		}
		$label = $GLOBALS['TL_LANG']['tl_li_task']['toggle']['0'];
		$title = sprintf($GLOBALS['TL_LANG']['tl_li_task']['toggle']['1'], $row['id']);

        return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
	}

	public function toggleVisibility($intId, $blnVisible)
	{
		\Input::setGet('id', $intId);
		\Input::setGet('act', 'toggle');

		// Update the database
		$this->Database->prepare("UPDATE tl_li_task SET tstamp=".time().", published='".($blnVisible ? 1 : '')."' WHERE id=?")->execute($intId);
		$this->createNewVersion('tl_li_task', $intId);
	}
	
	public function getTaskOptions(\DataContainer $dc)
	{
		$tasks = array();
		$objTasks = $this->Database->prepare("SELECT id, title FROM tl_li_task ORDER BY id ASC")->execute();
		while ($objTasks->next())
		{
			$tasks[$objTasks->id] = $objTasks->title;
		}
		return $tasks;
	}

	public function commentTask($row, $href, $label, $title, $icon, $attributes)
	{
		return '<a href="' . $this->addToUrl($href . '&amp;id=' . $row['id'] . '&amp;pid=' . $row['id']) . '" title="' . specialchars($title) . '"' . $attributes . '>' . $this->generateImage($icon, $label) . '</a> ';
	}


}
