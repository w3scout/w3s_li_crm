<?php if (!defined('TL_ROOT')) die("You cannot access this file directly!");

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @license     MIT (see /LICENSE.txt for further information)
 */

/**
 * Class Customer
 */
class MemberGroup extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
	}

    public function getExcludedFields()
    {
        $tableList = array
        (
            'tl_address',
            'tl_li_appointment',
            'tl_li_contact',
            'tl_li_invoice',
            'tl_li_product',
            'tl_li_project',
            'tl_li_service',
            'tl_li_task'
        );

        foreach($tableList as $table)
        {
            $this->loadLanguageFile($table);
            $this->loadDataContainer($table);
        }

        $arrReturn = array();

        // Get all excluded fields
        foreach ($GLOBALS['TL_DCA'] as $k=>$v)
        {
            if (is_array($v['fields']))
            {
                foreach ($v['fields'] as $kk=>$vv)
                {
                    if ($vv['exclude'] || $vv['orig_exclude'])
                    {
                        $arrReturn[$k][specialchars($k.'::'.$kk)] = (strlen($vv['label'][0]) ? $vv['label'][0] : $kk);
                    }
                }
            }
        }

        ksort($arrReturn);
        return $arrReturn;
    }
}
