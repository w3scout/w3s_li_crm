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
        $this->import('Database');
	}
    
    public function getCurrencySymbolArray()
    {
        $currencies = array(
            'EUR' => '&#0128;',
            'USD' => '$',
            'GBP' => '&#0163;',
            'CHF' => 'CHF',
        );
        if($GLOBALS['TL_CONFIG']['li_crm_company_default_currency'] != '') {
            $ordnerdCurrencies = array();
            foreach($currencies as $key => $currency) {
                if($GLOBALS['TL_CONFIG']['li_crm_company_default_currency'] == $key) {
                    $ordnerdCurrencies[$key] = $currency;
                    unset($currencies[$key]);
                    break;
                }
            }
            foreach($currencies as $key => $currency) {
                $ordnerdCurrencies[$key] = $currency;
            }
            $currencies = $ordnerdCurrencies;
        }

        return $currencies;
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

	public function getDefaultCurrency($value, $dc)
	{
		$objType = $this->Database
            ->prepare("SELECT currency FROM tl_li_service_type WHERE id = ?")->limit(1)
            ->execute($dc->activeRecord->toServiceType);

		return $objType->currency;
	}
}
