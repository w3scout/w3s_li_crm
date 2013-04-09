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
 * Class Settings
 */
class Settings extends \BackendModule
{
	protected $strTemplate = 'be_settings';

	protected function compile()
	{
		$this->loadLanguageFile('li_settings');
	}
}
