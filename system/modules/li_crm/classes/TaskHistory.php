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
 * Class TaskHistory
 */
class TaskHistory extends \Widget
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'be_widget';

	/**
	 * @var Database
	 */
	#protected $Database;

	/**
	 * Generate the widget and return it as string
	 * @return string
	 */
	public function generate()
	{
		$this->loadLanguageFile('tl_li_task');

		$this->import('Database');
		//$this->import('\LiCRM\TaskComment');

		$objTask = $this->Database
			->prepare("SELECT t.*
			 		   FROM tl_li_task t
			 		   INNER JOIN tl_li_task_comment c
			 		   ON t.id=c.pid
			 		   WHERE c.id=?")
			->execute(\Input::get('id'));

		if (!$objTask->next()) {
			return '';
		}

		$strComments = '';
		$intCommentCount = $this->Database
			->prepare("SELECT COUNT(c.id) as `count`
			 		   FROM tl_li_task_comment c
			 		   WHERE c.pid=?
			 		   ORDER BY c.tstamp DESC")
			->execute($objTask->id)
			->count;

        $objComment = $this->Database
			->prepare("SELECT @rownum:=@rownum-1 rownum, c.*
				       FROM (SELECT @rownum:=?) r, tl_li_task_comment c
				       WHERE c.pid=?
				       ORDER BY c.tstamp DESC")
			->limit(3)
			->execute($intCommentCount+1, $objTask->id);
		while ($objComment->next()) {
			$strComments .= $this->renderComment($objComment->row());
		}

		return '<div class="task_comments" id="comments_' . $objTask->id . '" data-offset="3" data-count="' . $intCommentCount . '">'
			. $strComments
			. '<div class="count">'
			. sprintf($GLOBALS['TL_LANG']['tl_li_task']['comment_count'], $intCommentCount)
			. ($intCommentCount > 3 ? '<a id="more_comments_' . $objTask->id . '" href="javascript:moreComments(' .$objTask->id . ')"> &rarr; ' . $GLOBALS['TL_LANG']['tl_li_task']['more_comments'] . '</a>' : '')
			. '</div>'
			. '</div>';
	}

    /**
     * @param $row
     * @param $label
     * @return string
     */
    public function renderComment($row)
    {

        $this->loadLanguageFile('tl_li_task_comment');

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
