<?php

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @author      Tristan Lins <tristan.lins@infinitysoft.de>
 * @license     MIT (see /LICENSE.txt for further information)
 */

/**
 * Table tl_li_task_comment
 */
$this->loadLanguageFile('tl_li_task_comment_reminder');

$GLOBALS['TL_DCA']['tl_li_task_comment'] = array
(
	// Config
	'config' => array
	(
	    'dataContainer'             => 'Table',
		'ptable'               		=> 'tl_li_task',
		'onload_callback'      		=> array
		(
			array('tl_li_task_comment', 'onLoad')
		),
		'onsubmit_callback'			=> array
		(
			array('tl_li_task_comment', 'onSubmit')
		),
		'doNotCopyRecords'     		=> true,
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
			'mode'             		=> 4,
			'headerFields'          => array('title', 'priority', 'deadline'),
			'fields'                => array('tstamp'),
			'flag'                  => 6,
			'panelLayout'           => 'limit',
			'child_record_callback' => array('tl_li_task_comment', 'renderComment')
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'   			=> &$GLOBALS['TL_LANG']['tl_li_task_comment']['edit'],
				'href'              => 'act=edit',
				'icon'              => 'edit.gif',
				'button_callback'	=> array('tl_li_task_comment', 'editButton')
			)
		)
	),
	
	// Palettes
	'palettes'	=> array
	(
		'__selector__'				=> array('changeCustomerProject', 'changePriority', 'changeTitle', 'changeDeadline', 'keeptime'),
		'default'         			=> '{settings_legend:hide},changeCustomerProject,changePriority,changeTitle,changeDeadline;
										{comment_legend},toStatus,toUser,comment;
										{timekeeping_legend},keeptime;
										{history_legend},history'
	),
	
	// Subpalettes
	'subpalettes' => array
	(
		'changeCustomerProject' 	=> 'toCustomer,toProject',
		'changePriority'        	=> 'priority',
		'changeTitle'           	=> 'title',
		'changeDeadline'        	=> 'deadline',
		'keeptime'              	=> 'hours,minutes,toWorkPackage'
	),
	
	// Fields
	'fields' => array
	(
        'id' => array(
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
        'pid' => array(
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
		'tstamp' => array
		(
			'default' => time(),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
        'user' => array
        (
            'default'                 => $this->User->id,
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
		'changeCustomerProject' => array
		(
			'label'             	=> &$GLOBALS['TL_LANG']['tl_li_task_comment']['changeCustomerProject'],
			'inputType'	        	=> 'checkbox',
			'eval'              	=> array('tl_class'=>'clr', 'submitOnChange'=>true),
            'sql'                   => "char(1) NOT NULL default ''"
		),
		'toCustomer' => array
		(
			'label'               	=> &$GLOBALS['TL_LANG']['tl_li_task_comment']['toCustomer'],
			'inputType'           	=> 'select',
			'options_callback'		=> array('LiCRM\Customer', 'getCustomerOptions'),
			'passToTask'          	=> 'changeCustomer',
			'eval'                	=> array('tl_class'=>'w50clr', 'includeBlankOption'=>true, 'submitOnChange'=>true, 'chosen'=>true),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'toProject' => array
		(
			'label'               	=> &$GLOBALS['TL_LANG']['tl_li_task_comment']['toProject'],
			'inputType'           	=> 'select',
			'options_callback'		=> array('LiCRM\Project', 'getProjectsOfCustomer'),
			'passToTask'          	=> 'changeProject',
			'eval'                	=> array('tl_class'=>'w50', 'includeBlankOption'=>true, 'chosen'=>true),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'changePriority' => array
		(
			'label'        			=> &$GLOBALS['TL_LANG']['tl_li_task_comment']['changePriority'],
			'inputType'				=> 'checkbox',
			'eval'         			=> array('tl_class'=>'clr', 'submitOnChange'=>true),
            'sql'                     => "char(1) NOT NULL default ''"
		),
		'priority' => array
		(
			'label'               	=> &$GLOBALS['TL_LANG']['tl_li_task_comment']['priority'],
			'inputType'           	=> 'select',
			'options_callback'		=> array('LiCRM\Task', 'getPriorityOptions'),
			'passToTask'          	=> 'changePriority',
			'eval'                	=> array('chosen'=>true),
            'sql'                     => "int(3) unsigned NOT NULL default '0'"
		),
		'changeTitle' => array
		(
			'label'        			=> &$GLOBALS['TL_LANG']['tl_li_task_comment']['changeTitle'],
			'inputType'				=> 'checkbox',
			'eval'         			=> array('tl_class'=>'clr', 'submitOnChange'=>true),
            'sql'                     => "char(1) NOT NULL default ''"
		),
		'title' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_task_comment']['title'],
			'inputType'             => 'text',
			'exclude'				=> true,
			'search'                => true,
			'passToTask'            => 'changeTitle',
			'eval'                  => array('maxlength'=> 250),
            'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'changeDeadline' => array
		(
			'label'        			=> &$GLOBALS['TL_LANG']['tl_li_task_comment']['changeDeadline'],
			'inputType'				=> 'checkbox',
			'eval'         			=> array('tl_class'=>'clr', 'submitOnChange'=>true),
            'sql'                     => "char(1) NOT NULL default ''"
		),
		'deadline' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_task_comment']['deadline'],
			'default'               => time(),
			'filter'                => true,
			'sorting'               => true,
			'flag'                  => 8,
			'inputType'             => 'text',
			'exclude'				=> true,
			'passToTask'            => 'changeDeadline',
			'eval'                  => array('rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'wizard'),
            'sql'                     => "varchar(10) NOT NULL default ''"
		),
        'previousStatus' => array
        (
            'sql'                   => "int(10) unsigned NOT NULL default '0'"
        ),
		'toStatus' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_li_task_comment']['toStatus'],
			'filter'                => true,
			'inputType'             => 'select',
			'exclude'				=> true,
			'foreignKey'            => 'tl_li_task_status.title',
			'passToTask'            => true,
			'eval'                  => array('includeBlankOption'=>true, 'tl_class'=>'w50', 'mandatory'=>true, 'chosen'=>true),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
        'previousUser' => array
        (
            'sql'                   => "int(10) unsigned NOT NULL default '0'"
        ),
		'toUser' => array
		(
			'label'         		=> &$GLOBALS['TL_LANG']['tl_li_task_comment']['toUser'],
			'inputType'     		=> 'select',
			'foreignKey'			=> 'tl_user.username',
			'passToTask'			=> true,
			'eval'          		=> array('tl_class'=>'w50', 'chosen'=>true),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'comment' => array
		(
			'label'        			=> &$GLOBALS['TL_LANG']['tl_li_task_comment']['comment'],
			'inputType'				=> 'textarea',
			'eval'         			=> array('tl_class'=>'clr', 'rte'=>'tinyMCE'),
            'sql'                     => "text NULL"
		),
		'keeptime' => array
		(
			'label'        			=> &$GLOBALS['TL_LANG']['tl_li_task_comment']['keeptime'],
			'inputType'				=> 'checkbox',
			'eval'         			=> array('submitOnChange'=> true),
            'sql'                     => "char(1) NOT NULL default ''"
		),
		'hours' => array
		(
			'label'        			=> &$GLOBALS['TL_LANG']['tl_li_task_comment']['hours'],
			'inputType'				=> 'text',
			'eval'         			=> array('rgxp'=>'digit', 'tl_class'=>'w50'),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'minutes' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_li_task_comment']['minutes'],
			'inputType'				=> 'text',
			'eval'         			=> array('rgxp'=>'digit', 'maxlength'=>'2', 'tl_class'=>'w50'),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'toWorkPackage' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_li_task_comment']['toWorkPackage'],
			'inputType'				=> 'select',
			'exclude'              	=> true,
			'options_callback'     	=> array('LiCRM\WorkPackage', 'getWorkPackages'),
			'eval'                 	=> array('mandatory'=>true, 'includeBlankOption'=>true, 'tl_class'=>'w50', 'chosen'=>true),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'history' => array
		(
			'label'                	=> &$GLOBALS['TL_LANG']['tl_li_task_comment']['history'],
			'inputType'				=> 'TaskHistory'
		),
        'working_hour_dataset' => array
        (
            'sql'                    => "int(10) unsigned NOT NULL default '0'"
        )
	)
);

class tl_li_task_comment  extends \Backend {


    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }

    /**
     * DataContainer load callback
     *
     * @param DataContainer $dc
     */
    public function onLoad(\DataContainer $dc)
    {
        switch (\Input::get('act')) {
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
                    ->execute(\Input::get('pid'));

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