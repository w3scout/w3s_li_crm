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
 * Class ServiceType
 */
class ServiceType extends \Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
	}
    
	public function renderLabel($row)
	{
        $image = $row['icon'] != "" && file_exists(TL_ROOT."/".$row['icon']) ? $row['icon'] : 'system/modules/li_crm/assets/service_default.png';
        
        return '<img src="'.$image.'" alt="'.$row['title'].'" /> '.$row['title'];
	}
}
