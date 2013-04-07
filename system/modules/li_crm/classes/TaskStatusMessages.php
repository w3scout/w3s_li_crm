<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011 | w3scouts.com Darko Selesi 2013
 * @author      Darko Selesi <hallo@w3scouts.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */

/**
 * Class TaskStatusMessages
 */
class TaskStatusMessages extends Backend
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