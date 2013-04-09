<?php
if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * PHP version 5
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */

class CRMRunonce extends Controller
{

	/**
	 * Initialize the object
	 */
	public function __construct()
	{
		parent::__construct();

		// Fix potential Exception on line 0 because of __destruct method (see http://dev.contao.org/issues/2236)
		$this->import((TL_MODE == 'BE' ? 'BackendUser' : 'FrontendUser'), 'User');
		$this->import('Database');
	}

	/**
	 * Run the controller
	 */
	public function run()
	{
		$currentVersion = '0.7.0';

		if (!empty($GLOBALS['TL_CONFIG']['li_crm_version']))
		{
			$this->Config->update("\$GLOBALS['TL_CONFIG']['li_crm_version']", $currentVersion);
		}
		else
		{
			$this->Config->add("\$GLOBALS['TL_CONFIG']['li_crm_version']", $currentVersion);
		}

	}

}

/**
 * Instantiate controller
 */
$crmRunner = new CRMRunonce();
$crmRunner->run();
