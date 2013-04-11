<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @license     MIT (see /LICENSE.txt for further information)
 */

namespace W3S\LiCRM;

/**
 * Class ModuleInvoiceReader
 */
class ModuleMobileAddressReader extends \Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_mobile_address_reader';

	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### MOBILE ADDRESS READER ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id='.$this->id;

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

        $alias = \Input::get('items');

        $objAddress = $this->Database->prepare("
            SELECT firstname, lastname, company, street, postal, city, country, email, website
            FROM tl_address
            WHERE id = ?
        ")->execute($alias);

        if ($objAddress->numRows == 1)
        {
            $arrAddress = array
            (
                'id' => $objAddress->id,
                'fields' => array
                (
                    'firstname' => $objAddress->firstname,
                    'lastname' => $objAddress->lastname,
                    'company' => $objAddress->company,
                    'street' => $objAddress->street,
                    'postal' => $objAddress->postal,
                    'city' => $objAddress->city,
                    'country' => $objAddress->country,
                    'email' => $objAddress->email,
                    'website' => $objAddress->website
                )

            );
            $this->Template->address = $arrAddress;
            $this->Template->addressFound = true;
        }

	}
}
