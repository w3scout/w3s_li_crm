<?php
if (!defined('TL_ROOT'))
	die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */
class Currency extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
	}
    
    /**
     * Gets an array of all available currencies, formatted in a way that it can be used to create a select-list
     * 
     * @return array All available currencies
     */
    public function getCurrencyOptions()
    {
        $this->loadLanguageFile('li_currency');
        
        $currencies = array_keys($GLOBALS['TL_LANG']['li_currency']['currency']);
        
        $options = array();
        foreach ($currencies as $currency => $name)
        {
            $options[$currency] = $name;
        }
        
        return $options;
    }
}
