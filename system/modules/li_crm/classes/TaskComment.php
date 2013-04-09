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
 * Class TaskComment
 */
class TaskComment extends \Backend
{
	/**
	 * @var Database
	 */
	protected $Database;

	/**
	 * @param $strAction
	 */
	public function hookExecutePreActions($strAction)
	{
		if ($strAction == 'moreComments') {
			$intPid    = intval($this->Input->post('pid'));
			$intOffset = intval($this->Input->post('offset'));

			$strBuffer = '';
			$intCommentCount = $this->Database
				->prepare("SELECT COUNT(id) as `count` FROM tl_li_task_comment WHERE pid=? ORDER BY tstamp DESC")
				->execute($intPid)
				->next()
				->count;
			$objComment = $this->Database
				->prepare("SELECT @rownum:=@rownum-1 rownum, c.*
				           FROM (SELECT @rownum:=?) r, tl_li_task_comment c
				           WHERE pid=?
				           ORDER BY tstamp DESC")
				->limit(3, $intOffset)
				->execute($intCommentCount-$intOffset+1, $intPid);
			while ($objComment->next()) {
				$strBuffer .= $this->renderComment($objComment->row());
			}

			header('Content-Type: application/javascript');
			echo json_encode(array(
				'token'   => REQUEST_TOKEN,
				'content' => $strBuffer
			));
			exit;
		}
	}

	/**
	 * DataContainer load callback
	 *
	 * @param DataContainer $dc
	 */
	public function onLoad(\DataContainer $dc)
	{
		switch ($this->Input->get('act')) {
			case 'edit':
				$this->import('\BackendUser', 'User');
				$this->User->authenticate();

				$objComment = $this->Database
					->prepare("SELECT * FROM tl_li_task_comment WHERE id=?")
					->execute($dc->id);
				if (!$objComment->next()) {
					$this->log('Could not found task comment ID ' . $dc->id, 'tl_li_task_comment::onLoad', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}

				if ($this->User->id != $objComment->user) {
					$this->log('User ' . $this->User->username . ' ID ' . $this->User->id . ' is not allowed to edit task comment ID ' . $dc->id, 'tl_li_task_comment::onLoad', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}

				if ($objComment->tstamp > 0 && time() - $objComment->tstamp > 3600) {
					$this->log('Edit task comments is only allowed 1 hour after creation', 'tl_li_task_comment::onLoad', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				break;

			case 'create':
				$objTask = $this->Database
					->prepare("SELECT * FROM tl_li_task WHERE id=?")
					->execute($this->Input->get('pid'));
				foreach ($GLOBALS['TL_DCA']['tl_li_task_comment']['fields'] as $name=> $field)
				{
					if (isset($field['passToTask'])) {
						$GLOBALS['TL_DCA']['tl_li_task_comment']['fields'][$name]['default'] = $objTask->$name;
					}
				}
				break;
		}
	}

	/**
	 * DataContainer submit callback
	 *
	 * @param DataContainer $dc
	 */
	public function onSubmit(\DataContainer $dc)
	{
		$objComment = $dc->activeRecord;

		if ($objComment->tstamp > 0
			&& $this->Database
				->prepare("SELECT * FROM tl_li_task_comment WHERE pid=? AND tstamp > ?")
				->execute($objComment->pid, $objComment->tstamp)
				->numRows > 0
		) {
			// do not update task, if this is not the latest comment!
			return;
		}

		$objTask   = $this->Database
			->prepare("SELECT * FROM tl_li_task WHERE id=?")
			->execute($objComment->pid);

		if ($objComment->previousStatus == 0) {
			$this->Database
				->prepare("UPDATE tl_li_task_comment SET previousStatus=? WHERE id=?")
				->execute($objTask->toStatus, $objComment->id);
		}

		if ($objComment->previousUser == 0) {
			$this->Database
				->prepare("UPDATE tl_li_task_comment SET previousUser=? WHERE id=?")
				->execute($objTask->toUser, $objComment->id);
		}

		$arrClear  = array();
		$arrUpdate = array();
		foreach ($GLOBALS['TL_DCA']['tl_li_task_comment']['fields'] as $name => $field)
		{
			if ($field['passToTask']) {
				$key = $field['passToTask'];
				if ($key === true || $objComment->$key) {
					if ($objComment->$name != $objTask->$name) {
						$arrUpdate[$name] = $objComment->$name;
					}
					else
					{
						$arrClear[$name] = '';
					}
				}
			}
		}

		// pass changes to task
		if (count($arrUpdate)) {
			$this->Database
				->prepare("UPDATE tl_li_task %s WHERE id=?")
				->set($arrUpdate)
				->execute($objTask->id);
		}

		if ($objComment->keeptime || $objComment->working_hour_dataset > 0)
		{
			if (!$objComment->keeptime) {
				$this->Database
					->prepare("DELETE FROM tl_li_working_hour WHERE id=?")
					->execute($objComment->working_hour_dataset);

				$this->Database
					->prepare("UPDATE tl_li_task_comment SET working_hour_dataset=? WHERE id=?")
					->execute(0, $objComment->id);
			}
			else {
				$objDateTime = new \DateTime();
				if ($objComment->tstamp > 0) {
					$objDateTime->setTimestamp($objComment->tstamp);
				}
				$objDateTime->setTime(0, 0, 0);
				$arrSet = array(
					'user' => $objComment->user,
					'entryDate' => $objDateTime->getTimestamp(),
					'hours'     => $objComment->hours ? $objComment->hours : 0,
					'minutes' => $objComment->minutes ? $objComment->minutes : 0,
					'toWorkPackage' => $objComment->toWorkPackage
				);

				if ($objComment->working_hour_dataset > 0) {
					$this->Database
						->prepare("UPDATE tl_li_working_hour %s WHERE id=?")
						->set($arrSet)
						->execute($objComment->working_hour_dataset);
				} else {
					$objStatement = $this->Database
						->prepare("INSERT INTO tl_li_working_hour %s")
						->set($arrSet);
					$objStatement->execute();

					$this->Database
						->prepare("UPDATE tl_li_task_comment SET working_hour_dataset=? WHERE id=?")
						->execute($objStatement->insertId, $objComment->id);
				}
			}
		}
	}

	/**
	 * Edit button callback
	 *
	 * @param $row
	 * @param $href
	 * @param $label
	 * @param $title
	 * @param $icon
	 * @param $attributes
	 * @return string
	 */
	public function editButton($row, $href, $label, $title, $icon, $attributes)
	{
		return $this->User->id == $row['id'] // only allow users edit their own comments (also admins)
			&& time() - $row['tstamp'] < 3600 // only allow edit, 60 minutes after creation
			? '<a href="' . $this->addToUrl($href . '&amp;id=' . $row['id']) . '" title="' . specialchars($title) . '"' . $attributes . '>' . $this->generateImage($icon, $label) . '</a> '
			: '';
	}


	/**
	 * @param $row
	 * @param $label
	 * @return string
	 */
	public function renderComment($row)
	{
		if (!isset($GLOBALS['TL_LANG']['tl_li_task_comment'])) {
			$this->loadLanguageFile('tl_li_task_comment');
		}

		$objTemplate = new \BackendTemplate('be_task_comment');
		$objTemplate->setData($row);

		$objTemplate->datetime = $this->parseDate($GLOBALS['TL_CONFIG']['datimFormat'], $row['tstamp']);
		$objTemplate->date     = $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $row['tstamp']);

		$objTemplate->user = $this->Database
			->prepare("SELECT * FROM tl_user WHERE id=?")
			->execute($row['user']);

		if ($row['toCustomer']) {
			$objTemplate->customer = $this->Database
				->prepare("SELECT * FROM tl_member WHERE id=?")
				->execute($row['toCustomer']);
		}

		if ($row['toProject']) {
			$objTemplate->project = $this->Database
				->prepare("SELECT * FROM tl_li_project WHERE id=?")
				->execute($row['toProject']);
		}

		$objTemplate->pstatus = $this->Database
			->prepare("SELECT * FROM tl_li_task_status WHERE id=?")
			->execute($row['previousStatus']);

		$objTemplate->status = $this->Database
			->prepare("SELECT * FROM tl_li_task_status WHERE id=?")
			->execute($row['toStatus']);

		$objTemplate->puser = $this->Database
			->prepare("SELECT * FROM tl_user WHERE id=?")
			->execute($row['previousUser']);

		$objTemplate->tuser = $this->Database
			->prepare("SELECT * FROM tl_user WHERE id=?")
			->execute($row['toUser']);

		$objTemplate->workPackage = $this->Database
			->prepare("SELECT * FROM tl_li_work_package WHERE id=?")
			->execute($row['toWorkPackage']);

		return $objTemplate->parse();
	}
}
