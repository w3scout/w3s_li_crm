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
 * Class Product
 */
class Product extends \Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
	}
    
    public function getProducts()
    {
        $products = array();
        
        $getProducts = $this->Database->prepare("
        	SELECT p.id, p.title, price, t.title AS type
            FROM tl_li_product AS p
            INNER JOIN tl_li_product_type AS t
            	ON p.toProductType = t.id
            ORDER BY p.title
        ")->execute();
        while ($getProducts->next())
        {
            $products[] = array
            (
                'id'    => $getProducts->id,
                'title' => $getProducts->title,
                'price' => $getProducts->price,
                'type'  => $getProducts->type,
            );
        }
        
        return $products;
    }
    
    public function getProductsList()
    {
        $products = $this->getProducts();
        $productList = array();
        foreach ($products as $product)
        {
            $productList[$product['type']][$product['id']] = $product['title'].' ('.$product['price'].')';
        }
        return $productList;
    }

    public function getUnitOptions() {
        return array
        (
            'unit' => $GLOBALS['TL_LANG']['tl_li_product']['units']['unit'],
            'hour' => $GLOBALS['TL_LANG']['tl_li_product']['units']['hour'],
            'month' => $GLOBALS['TL_LANG']['tl_li_product']['units']['month'],
            'year' => $GLOBALS['TL_LANG']['tl_li_product']['units']['year']
        );
    }
}
