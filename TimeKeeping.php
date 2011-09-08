<?php
if (!defined('TL_ROOT'))
	die('You cannot access this file directly!');

/**
 * @author apoy2k
 */
class TimeKeeping extends BackendModule
{
	protected $strTemplate = 'be_time_keeping';
	
	public function generate()
	{
		parent::generate();
		
		return $this->Template->parse();
	}
	
	protected function compile();
}
