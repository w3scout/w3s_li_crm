<?php
if (!defined('TL_ROOT'))
	die('You cannot access this file directly!');

/**
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     apoy2k
 * @license    MIT (see /LICENSE.txt for further information)
 */
class Product extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
	}
    
    /**
     * Gets all products and their product type
     * 
     * @return array All products as an indexed array
     */
    public function getProducts()
    {
        $products = array();
        
        $getProducts = $this->Database->prepare("SELECT p.id, p.title, price, t.title AS type
            FROM tl_li_product AS p
                INNER JOIN tl_li_product_type AS t ON p.toProductType = t.id
            ORDER BY p.title")->execute();
        while ($getProducts->next())
        {
            $products[] = array(
                'id'    => $getProducts->id,
                'title' => $getProducts->title,
                'price' => $getProducts->price,
                'type'  => $getProducts->type,
            );
        }
        
        return $products;
    }
    
    /**
     * Gets all products and groups them by their types. The productId is used as the index so the
     * array can be used as base for a select-list
     * 
     * @return array The products grouped by their type
     */
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
}
