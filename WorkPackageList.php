<?php
if (!defined('TL_ROOT'))
	die('You cannot access this file directly!');

/**
 * @author apoy2k
 */
class WorkPackageList extends BackendModule
{
	protected $strTemplate = 'be_workpackage_list';
	
	public function generate()
	{
		parent::generate();
		return $this->Template->parse();
	}
	
	protected function compile()
	{
	}
}
