<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      Tristan Lins <tristan.lins@infinitysoft.de>
 * @license     MIT (see /LICENSE.txt for further information)
 */

/**
 * Class TaskHistory
 */
class TaskHistory extends Widget
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'be_widget';

	/**
	 * @var Database
	 */
	protected $Database;

	/**
	 * Generate the widget and return it as string
	 * @return string
	 */
	public function generate()
	{
		$this->loadLanguageFile('tl_li_task');

		$this->import('Database');
		$this->import('TaskComment');

		$objTask = $this->Database
			->prepare("SELECT t.*
			 		   FROM tl_li_task t
			 		   INNER JOIN tl_li_task_comment c
			 		   ON t.id=c.pid
			 		   WHERE c.id=?")
			->execute($this->Input->get('id'));

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
			$strComments .= $this->TaskComment->renderComment($objComment->row());
		}

		return '<div class="task_comments" id="comments_' . $objTask->id . '" data-offset="3" data-count="' . $intCommentCount . '">'
			. $strComments
			. '<div class="count">'
			. sprintf($GLOBALS['TL_LANG']['tl_li_task']['comment_count'], $intCommentCount)
			. ($intCommentCount > 3 ? '<a id="more_comments_' . $objTask->id . '" href="javascript:moreComments(' .$objTask->id . ')"> &rarr; ' . $GLOBALS['TL_LANG']['tl_li_task']['more_comments'] . '</a>' : '')
			. '</div>'
			. '</div>';
	}
}
