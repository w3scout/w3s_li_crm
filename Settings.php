<?php
if (!defined('TL_ROOT'))
	die('You cannot access this file directly!');

/**
 * PHP version 5
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */

/**
 * Class CRMSettings
 */
class Settings extends BackendModule
{
	protected $strTemplate = 'be_settings';

	protected function compile()
	{
		$this->loadLanguageFile('li_settings');
	}

}
?>