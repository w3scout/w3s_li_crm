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
 * Class Task
 */
class Task extends BackendModule
{
	/**
	 * @var TaskComment
	 */
	protected $TaskComment;

	/**
	 * @var BackendUser
	 */
	protected $User;
	
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

		$key = $this->Input->get('key');
		$id = $this->Input->get('id');

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

	public function generateAlias($varValue, DataContainer $dc)
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
			throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
		}

		// Add ID to alias
		if ($objAlias->numRows && $autoAlias)
		{
			$varValue .= '-'.$dc->id;
		}

		return $varValue;
	}

	public function renderLabel($row, $label)
	{
		$statusIcon = '<img src="system/modules/li_crm/icons/status_default.png" alt="'.$GLOBALS['TL_LANG']['tl_li_task']['defaultIcon'].'" style="vertical-align:-3px;" />';

		if ($row['toStatus'] != 0)
		{
			$objStatus = $this->Database->prepare("SELECT title, icon, isTaskDisabled
			    FROM tl_li_task_status
			    WHERE id = ?")->limit(1)->execute($row['toStatus']);

			if ($objStatus->icon != '')
			{
				$statusIcon = '<img src="'.$objStatus->icon.'" alt="'.$objStatus->title.'" style="vertical-align: -3px;" />';
			}
			if ($objStatus->isTaskDisabled)
			{
				$taskDisabled = true;
			}
		}

		if ($row['toProject'] != 0)
		{
			$objCustomer = $this->Database->prepare("SELECT c.customerNumber, c.customerName
			    FROM tl_li_project AS p
			        INNER JOIN tl_member AS c ON p.toCustomer = c.id
			    WHERE p.id = ?")->limit(1)->execute($row['toProject']);

			$customer = $objCustomer->customerNumber." ".$objCustomer->customerName;
		}
		else if ($row['toCustomer'] != 0)
		{
			$objCustomer = $this->Database
				->prepare("SELECT c.customerNumber, c.customerName
					       FROM tl_member c
					       WHERE id = ?")
				->limit(1)
				->execute($row['toCustomer']);

			$customer = $objCustomer->customerNumber." ".$objCustomer->customerName;
		}
		else
		{
			$customer = $GLOBALS['TL_LANG']['tl_li_task']['noCustomer'];
		}
		
		/**
		 * Add the expand comments icon.
		 */
		$expandIcon = '<span class="toggle_comments">' . $this->generateImage('system/themes/' . $this->getTheme() . '/images/folPlus.gif', '') . '</span> ';
		
		/**
		 * Add the last 3 comments.
		 */
		$this->import('TaskComment');
		$strComments = '';
		$intCommentCount = $this->Database
			->prepare("SELECT COUNT(id) as `count` FROM tl_li_task_comment WHERE pid=? ORDER BY tstamp DESC")
			->execute($row['id'])
			->count;
		$objComment = $this->Database
			->prepare("SELECT @rownum:=@rownum-1 rownum, c.*
				       FROM (SELECT @rownum:=?) r, tl_li_task_comment c
				       WHERE pid=?
				       ORDER BY tstamp DESC")
			->limit(3)
			->execute($intCommentCount+1, $row['id']);
		while ($objComment->next()) {
			$strComments .= $this->TaskComment->renderComment($objComment->row());
		}
		$strComments = '<div class="task_comments" id="comments_' . $row['id'] . '" data-offset="3" data-count="' . $intCommentCount . '">'
			. $strComments
			. '<div class="count">'
			. sprintf($GLOBALS['TL_LANG']['tl_li_task']['comment_count'], $intCommentCount)
			. ($intCommentCount > 3 ? '<a id="more_comments_' . $row['id'] . '" href="javascript:moreComments(' . $row['id'] . ')"> &rarr; ' . $GLOBALS['TL_LANG']['tl_li_task']['more_comments'] . '</a>' : '')
			. '</div>'
			. '</div>';

		if (!$taskDisabled)
		{
			$priorityIcon = '<img src="system/modules/li_crm/icons/priority_'.$row['priority'].'.png" alt="'.$GLOBALS['TL_LANG']['tl_li_task']['priority'][0].' '.$row['priority'].'" style="vertical-align:-3px;" />';

			return '<div>' . $expandIcon . $priorityIcon." ".$statusIcon." ".$customer." - ".$row['title'] . '</div>' . $strComments;
		}
		else
		{
			$priorityIcon = '<img src="system/modules/li_crm/icons/priority_'.$row['priority'].'_disabled.png" alt="'.$GLOBALS['TL_LANG']['tl_li_task']['priority'][0].' '.$row['priority'].'" style="vertical-align:-3px;" />';

			return '<div>' . $expandIcon . $priorityIcon." ".$statusIcon." <span class=\"disabled\">".$customer." - ".$row['title']."</span>" . '</div>' . $strComments;
		}
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

	public function taskDoneIcon($row, $href, $label, $title, $icon, $attributes)
	{
		$alt = $GLOBALS['TL_LANG']['tl_li_task']['done'][0];
		$objTask = $this->Database->prepare('SELECT s.isTaskDone
											 FROM tl_li_task AS t
											 INNER JOIN tl_li_task_status AS s ON s.id = t.toStatus
											 WHERE t.id = ?')->limit(1)->execute($row['id']);
		if (!$objTask->isTaskDone)
		{
			$href = '&amp;do=li_tasks&amp;key=done&amp;id='.$row['id'];
			$title = sprintf($GLOBALS['TL_LANG']['tl_li_task']['done'][1], $row['id']);
			return '<a href="'.$this->addToUrl($href).'" title="'.$title.'"><img src="system/modules/li_crm/icons/task_done.png" alt="'.$alt.'" /></a> ';
		}
		else
		{
			return '<img src="system/modules/li_crm/icons/task_done_disabled.png" alt="'.$alt.'" /> ';
		}
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
		if (strlen($this->Input->get('tid')))
		{
			$this->toggleVisibility($this->Input->get('tid'), ($this->Input->get('state') == 1));
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
		$this->Input->setGet('id', $intId);
		$this->Input->setGet('act', 'toggle');

		// Update the database
		$this->Database->prepare("UPDATE tl_li_task SET tstamp=".time().", published='".($blnVisible ? 1 : '')."' WHERE id=?")->execute($intId);
		$this->createNewVersion('tl_li_task', $intId);
	}
	
	public function getTaskOptions(DataContainer $dc)
	{
		$tasks = array();
		$objTasks = $this->Database->prepare("SELECT id, title FROM tl_li_task ORDER BY id ASC")->execute();
		while ($objTasks->next())
		{
			$tasks[$objTasks->id] = $objTasks->title;
		}
		return $tasks;
	}


	/**
	 * DataContainer submit callback
	 *
	 * @param DataContainer $dc
	 */
	public function onSubmit(DataContainer $dc)
	{
		$this->import('BackendUser', 'User');
		$this->User->authenticate();

		$objTask = $dc->activeRecord;

		$arrSet = array(
			'pid' => $objTask->id,
			'tstamp' => $objTask->tstamp,
			'user' => $this->User->id,
			'changeCustomerProject' => $objTask->toCustomer > 0 ? 1 : '',
			'toCustomer' => $objTask->toCustomer,
			'toProject' => $objTask->toProject,
			'changePriority' => 1,
			'priority' => $objTask->priority,
			'changeTitle' => 1,
			'title' => $objTask->title,
			'changeDeadline' => 1,
			'deadline' => $objTask->deadline,
			'previousStatus' => 0,
			'toStatus' => $objTask->toStatus,
			'previousUser' => 0,
			'toUser' => $objTask->toUser,
			'comment' => $objTask->description
		);

		$objComment = $this->Database
			->prepare("SELECT * FROM tl_li_task_comment WHERE pid=? ORDER BY tstamp ASC")
			->limit(1)
			->execute($objTask->id);
		if ($objComment->next()) {
			unset($arrSet['user']); // do not update user
			$this->Database
				->prepare("UPDATE tl_li_task_comment %s WHERE id=?")
				->set($arrSet)
				->execute($objComment->id);
		} else {
			$this->Database
				->prepare("INSERT INTO tl_li_task_comment %s")
				->set($arrSet)
				->execute();
		}
	}

}
?>