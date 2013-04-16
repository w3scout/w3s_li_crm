<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @license     MIT (see /LICENSE.txt for further information)
 */

namespace W3S\LiCRM;

/**
 * Class ModuleInvoiceList
 */
class ModuleMobileCustomerList extends \Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_mobile_customer_list';

	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### MOBILE CUSTOMER LIST ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		return parent::generate();
	}


	/**
	 * Generate module
	 */
	protected function compile()
	{
		$this->import('FrontendUser', 'User');
        $this->loadLanguageFile('tl_member');
        $this->loadLanguageFile('tl_address');
		
        $objCustomers = $this->Database->prepare("
            SELECT c.id, c.customerNumber, c.customerName
            FROM tl_member AS c
            WHERE c.isCustomer = 1
                AND NOT c.customerNumber = ''
                AND NOT c.customerName = ''
                AND disable = ''
            ORDER BY c.customerNumber ASC
        ")->execute();
		
		$objPage = $this->Database->prepare("
			SELECT id, alias
			FROM tl_page
			WHERE id = ?
		")->limit(1)->execute($this->jumpTo);
		
		$arrCustomers = array();
		while($objCustomers->next() != null)
		{
            $objAddresses = $this->Database->prepare("
                SELECT a.id, a.firstname, a.lastname
                FROM tl_address AS a
                WHERE a.pid = ?
                ORDER BY a.firstname ASC
            ")->execute($objCustomers->id);
            $arrAddresses = array();
            while($objAddresses->next() != null) {
                $arrAddresses[] = array
                (
                    'id' => $objAddresses->id,
                    'firstname' => $objAddresses->firstname,
                    'lastname' => $objAddresses->lastname,
                    'link' => $this->generateFrontendUrl($objPage->row(), '/items/'. $objAddresses->id)
                );
            }
            $arrCustomers[] = array
			(
				'id' => $objCustomers->id,
				'customerNumber' => $objCustomers->customerNumber,
				'customerName' => $objCustomers->customerName,
                'countAddresses' => count($arrAddresses),
                'addresses' => $arrAddresses
			);
		}
		
		$this->Template->user = $this->User;
		$this->Template->customers = $arrCustomers;
	}
}
