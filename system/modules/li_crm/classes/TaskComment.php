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
	#protected $Database;

	/**
	 * @param $strAction
	 */
	public function hookExecutePreActions($strAction)
	{
		if ($strAction == 'moreComments') {
			$intPid    = intval(\Input::post('pid'));
			$intOffset = intval(\Input::post('offset'));

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
