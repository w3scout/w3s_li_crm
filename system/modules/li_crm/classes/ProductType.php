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
 * Class ProductType
 */
class ProductType extends \Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->import('Database');
    }
    
    public function getLabel($row)
    {
        $image = file_exists($row['icon']) ? $row['icon'] : 'system/modules/li_crm/assets/products.png';
        
        return '<img src="'.$image.'" alt="'.$row['title'].'" /> '.$row['title'];
    }
}
