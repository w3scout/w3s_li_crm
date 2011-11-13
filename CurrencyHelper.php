<?php
if (!defined('TL_ROOT'))
	die('You cannot access this file directly!');

/**
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */
class CurrencyHelper extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}
    
    public function getCurrencySymbolArray()
    {
        return array(
            'EUR' => '&euro;',
            'USD' => '$',
            'GBP' => '&pound;',
            'CHF' => 'sFR',
        );
    }

    public function getCurrencyOptions()
    {
        $list = array();
        foreach ($this->getCurrencySymbolArray() as $code => $symbol)
        {
            $list[$code] = $code.' - '.$symbol;
        }
        return $list;
    }

    public function getSymbolOfCode($code)
    {
        $list = $this->getCurrencySymbolArray();
        return $list[$code];
    }
}
