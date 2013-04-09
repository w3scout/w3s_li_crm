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
 * Class TaskStatusMessages
 */
class TaskStatusMessages extends \Backend
{
    public function __construct()
    {
        parent::__construct();
        $this->loadLanguageFile('tl_li_task_status_messages');
    }

    public function listTasks()
    {
        $this->import('BackendUser', 'User');

        $arrReturn = array();

        $objTask = $this->Database->prepare("
                        SELECT t.title as title, s.title as status
                        FROM tl_li_task t
                        LEFT JOIN tl_li_task_status s ON t.toStatus=s.id
                        WHERE s.showOnStartpage=? AND published=? " . (!$this->User->isAdmin ? " AND (t.toUser=?)" : ""))
                    ->execute(1,1,$this->User->id);

        if ($objTask->numRows)
        {
            $arrReturn[] = '<p class="tl_info"><a href="contao/main.php?do=li_tasks">'.sprintf($GLOBALS['TL_LANG']['tl_li_task_status_messages']['task'], $objTask->title, $objTask->status).'</a></p>';
        }

        return implode("\n", $arrReturn);
    }

}
?>