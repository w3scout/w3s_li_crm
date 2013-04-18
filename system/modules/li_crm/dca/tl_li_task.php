<?php

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @author      Tristan Lins <tristan.lins@infinitysoft.de>
 * @author      Darko Selesi <hallo@w3scouts.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */

/**
 * Table tl_li_task
 */
$this->loadLanguageFile('tl_li_task_reminder');

$GLOBALS['TL_DCA']['tl_li_task'] = array
(
	// Config
	'config' => array
	(
	    'dataContainer'             => 'Table',
		'ctable'                    => array('tl_li_task_comment'),
		'enableVersioning'          => true,
		'onsubmit_callback'			=> array
		(
			array('tl_li_task', 'onSubmit')
		),
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary'
            )
        )
	),
	
	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                  => 1,
			'fields'                => array('toStatus', 'priority'),
			'flag'                  => 1,
			'panelLayout'           => 'filter;sort,search,limit'
		),
		'label' => array
		(
			'fields'                => array('title'),
			'label_callback'        => array('tl_li_task', 'renderLabel')
		),
		'global_operations' => array
		(
            'reminder' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_task']['reminder'],
				'href'              => 'table=tl_li_task_reminder',
				'class'             => 'header_task_reminder',
				'attributes'        => 'onclick="Backend.getScrollOffset();"'
			),
            'all' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'              => 'act=select',
				'class'             => 'header_edit_all',
				'attributes'        => 'onclick="Backend.getScrollOffset();"'
			)
		),
		'operations' => array
		(
			'comment' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_task']['comment'],
				'href'              => 'table=tl_li_task_comment&amp;act=create&amp;mode=2',
				'icon'              => 'system/modules/li_crm/assets/comment.png',
				'button_callback'   => array('LiCRM\Task', 'commentTask')
			),
			'copy' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_task']['copy'],
				'href'              => 'act=copy',
				'icon'              => 'copy.gif'
			),
			'delete' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_task']['delete'],
				'href'              => 'act=delete',
				'icon'              => 'delete.gif',
				'attributes'        => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'toggle' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_task']['toggle'],
				'icon'              => 'visible.gif',
				'attributes'        => 'onclick="Backend.getScrollOffset(); return AjaxRequest.toggleVisibility(this, %s);"',
				'button_callback'   => array('LiCRM\Task', 'toggleIcon')
			),
			'show' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_task']['show'],
				'href'              => 'act=show',
				'icon'              => 'show.gif'
			),
			'new_reminder' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_task_reminder']['new'],
				'href'              => 'table=tl_li_task_reminder&act=create',
				'icon'              => 'system/modules/li_crm/assets/reminder_add.png'
			),
			'done' => array
			(
				'label'             => &$GLOBALS['TL_LANG']['tl_li_task']['done'],
				'icon'              => 'system/modules/li_crm/assets/task_done_disabled.png',
				'attributes'        => 'onclick="Backend.getScrollOffset();"',
				'button_callback'   => array('tl_li_task', 'taskDoneIcon')
			)
		)
	),
	
	// Palettes
	'palettes' => array
	(
		'__selector__'              => array(''),
		'default'                   => '{task_legend}, title, alias, deadline, description;
		                                {settings_legend}, toCustomer, toProject, toStatus, toUser, priority;
										{publish_legend},published;'
	),
	
	// Fields
	'fields' => array
	(
        'id' => array(
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp' => array
		(
			'default' => time(),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
        'toCustomer' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_task']['toCustomer'],
			'inputType'             => 'select',
			'filter'                => true,
            'exclude'   			=> true,
			'options_callback'      => array('LiCRM\Customer', 'getCustomerOptions'),
			'eval'                  => array('tl_class'=>'w50', 'chosen'=>true, 'includeBlankOption'=>true, 'submitOnChange'=>true),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
        'toProject' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_task']['toProject'],
			'inputType'             => 'select',
			'exclude'   			=> true,
			'options_callback'      => array('LiCRM\Project', 'getProjectsOfCustomer'),
            'eval'                  => array('tl_class'=>'w50', 'chosen'=>true, 'includeBlankOption'=>true),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
        'toStatus' => array
		(
            'label'                 => &$GLOBALS['TL_LANG']['tl_li_task']['toStatus'],
			'filter'                => true,
			'inputType'             => 'select',
			'exclude'   			=> true,
            'foreignKey'            => 'tl_li_task_status.title',
			'eval'                  => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50', 'mandatory'=>true),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'toUser' => array
		(
            'label'                 => &$GLOBALS['TL_LANG']['tl_li_task']['toUser'],
			'filter'                => true,
			'inputType'             => 'select',
			'exclude'   			=> true,
            'foreignKey'            => 'tl_user.username',
			'eval'                  => array('tl_class'=>'w50', 'chosen'=>true),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'priority' => array
		(
            'label'                 => &$GLOBALS['TL_LANG']['tl_li_task']['priority'],
			'filter'                => true,
			'inputType'             => 'select',
			'exclude'   			=> true,
			'options_callback'      => array('LiCRM\Task', 'getPriorityOptions'),
			'eval'                  => array('tl_class'=>'w50', 'chosen'=>true),
            'sql'                     => "int(3) unsigned NOT NULL default '0'"
        ),
        'title' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_task']['title'],
			'inputType'             => 'text',
			'exclude'   			=> true,
			'search'                => true,
			'eval'                  => array('mandatory'=>true, 'maxlength'=>250, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'alias' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_task']['alias'],
			'inputType'             => 'text',
			'exclude'   			=> true,
			'eval'                  => array('rgxp'=>'alnum', 'unique'=>true, 'spaceToUnderscore'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'save_callback' 		=> array
			(
				array('LiCRM\Task', 'generateAlias')
			),
            'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'deadline' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_task']['deadline'],
			'default'               => time(),
			'filter'                => true,
			'sorting'               => true,
			'flag'                  => 8,
			'inputType'             => 'text',
			'exclude'   			=> true,
			'eval'                  => array('rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
            'sql'                     => "varchar(10) NOT NULL default ''"
		),
		'description' => array
		(
            'label'                 => &$GLOBALS['TL_LANG']['tl_li_task']['description'],
			'search'                => true,
			'inputType'             => 'textarea',
			'exclude'   			=> true,
			'eval'                  => array('tl_class'=>'clr', 'rte'=>'tinyMCE'),
            'sql'                     => "text NULL"
        ),
		'published' => array
		(
            'label'                 => &$GLOBALS['TL_LANG']['tl_li_task']['published'],
			'inputType'             => 'checkbox',
			'exclude'   			=> true,
			'filter'                => true,
            'sql'                     => "char(1) NOT NULL default ''"
        )
	)
);


class tl_li_task  extends \Backend {

    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
        $this->User->authenticate();
    }

    /**
     * DataContainer submit callback
     *
     * @param DataContainer $dc
     */
    public function onSubmit(\DataContainer $dc)
    {

        $objTask = $dc->activeRecord;

        $arrSet = array(
            'pid'                   => $objTask->id,
            'tstamp'                => time(),
            'user'                  => $this->User->id,
            'changeCustomerProject' => $objTask->toCustomer > 0 ? 1 : '',
            'toCustomer'            => $objTask->toCustomer,
            'toProject'             => $objTask->toProject,
            'changePriority'        => 1,
            'priority'              => $objTask->priority,
            'changeTitle'           => 1,
            'title'                 => $objTask->title,
            'changeDeadline'        => 1,
            'deadline'              => $objTask->deadline,
            'previousStatus'        => 0,
            'toStatus'              => $objTask->toStatus,
            'previousUser'          => 0,
            'toUser'                => $objTask->toUser,
            'comment'               => $objTask->description
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
        }
        else {
            $this->Database
                ->prepare("INSERT INTO tl_li_task_comment %s")
                ->set($arrSet)
                ->execute();
        }
    }

    public function renderLabel($row, $label)
    {

        $statusIcon = '<img src="system/modules/li_crm/assets/status_default.png" alt="'.$GLOBALS['TL_LANG']['tl_li_task']['defaultIcon'].'" style="vertical-align:-3px;" />';

        if ($row['toStatus'] != 0)
        {
            $objStatus = $this->Database->prepare("
                  SELECT title, icon, isTaskDisabled
			      FROM tl_li_task_status
			      WHERE id = ?")
                ->limit(1)
                ->execute($row['toStatus']);

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
            $objCustomer = $this->Database->prepare("
                  SELECT c.customerNumber, c.customerName
			      FROM tl_li_project AS p
			        INNER JOIN tl_member AS c ON p.toCustomer = c.id
			      WHERE p.id = ?")
                ->limit(1)
                ->execute($row['toProject']);

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
        //$this->import('LiCRM\TaskComment');
        $strComments = '';

        $intCommentCount = $this->Database
            ->prepare("SELECT COUNT(id) as count FROM tl_li_task_comment WHERE pid=? ORDER BY tstamp DESC")
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
            $strComments .= $this->renderComment($objComment->row());
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
            $priorityIcon = '<img src="system/modules/li_crm/assets/priority_'.$row['priority'].'.png" alt="'.$GLOBALS['TL_LANG']['tl_li_task']['priority'][0].' '.$row['priority'].'" style="vertical-align:-3px;" />';

            return '<div>' . $expandIcon . $priorityIcon." ".$statusIcon." ".$customer." - ".$row['title'] . '</div>' . $strComments;
        }
        else
        {
            $priorityIcon = '<img src="system/modules/li_crm/assets/priority_'.$row['priority'].'_disabled.png" alt="'.$GLOBALS['TL_LANG']['tl_li_task']['priority'][0].' '.$row['priority'].'" style="vertical-align:-3px;" />';

            return '<div>' . $expandIcon . $priorityIcon." ".$statusIcon." <span class=\"disabled\">".$customer." - ".$row['title']."</span>" . '</div>' . $strComments;
        }
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

    public function taskDoneIcon($row, $href, $label, $title, $icon, $attributes)
    {
        $alt = $GLOBALS['TL_LANG']['tl_li_task']['done'][0];
        $objTask = $this->Database->prepare("
                              SELECT s.isTaskDone
							  FROM tl_li_task AS t
							    INNER JOIN tl_li_task_status AS s ON s.id = t.toStatus
							  WHERE t.id = ?")
                            ->limit(1)
                            ->execute($row['id']
        );
        if (!$objTask->isTaskDone)
        {
            $href = '&amp;do=li_tasks&amp;key=done&amp;id='.$row['id'];
            $title = sprintf($GLOBALS['TL_LANG']['tl_li_task']['done'][1], $row['id']);
            return '<a href="'.$this->addToUrl($href).'" title="'.$title.'"><img src="system/modules/li_crm/assets/task_done.png" alt="'.$alt.'" /></a> ';
        }
        else
        {
            return '<img src="system/modules/li_crm/assets/task_done_disabled.png" alt="'.$alt.'" /> ';
        }
    }
}