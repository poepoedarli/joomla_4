<?php
/**
 * @package Sj Flat Menu
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2013 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Cache\CacheControllerFactoryInterface;
use Joomla\CMS\Cache\Controller\OutputController;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Router\Route;

abstract class FlatMenuHelper
{
	public static function getList(&$params)
	{
		$list		= array();
		$db		= JFactory::getDbo();
		$user		= JFactory::getUser();
		$app		= JFactory::getApplication();
		$menu		= $app->getMenu();
		$active = ($menu->getActive()) ? $menu->getActive() : $menu->getDefault();
		$path		= $active->tree;
		$startLevel = $params->get("startlevel", 1);
		$endLevel = $params->get("endlevel", "all");
		$showSub = $params->get("showsub", "true");
		$menuType = $params->get("menutype");
		$items 		= $menu->getItems('menutype',$menuType);
		$lastitem	= 0;
		
		if ($items) {
			foreach($items as $i => $item)
			{
				$itemParams   = $item->getParams();
				if (($startLevel && $item->level < $startLevel)
					|| ($endLevel && $endLevel != "all" && $item->level > $endLevel  )
					|| ($showSub == "false" && $item->level > $startLevel)
				) {
					unset($items[$i]);
					continue;
				}
				
				
				//print_r($active);
				//die;
				//echo $item->parent_id . '' . $active . '<br/>';. 
				
				/*if ($item->level > 1 && !in_array($item->parent_id, $path)) {
					unset($items[$i]);
					continue;
				}*/
				$path[] = $item->id;
				$item->parent = (boolean) $menu->getItems('parent_id', (int) $item->id, true);
				$lastitem			= $i;
				$item->active		= false;
				$item->flink = $item->link;
				
				switch ($item->type)
				{
					case 'separator':
						continue 2;
					case 'url':
						if ((strpos($item->link, 'index.php?') === 0) && (strpos($item->link, 'Itemid=') === false)) {
							$item->flink = $item->link.'&Itemid='.$item->id;
						}
						break;
					case 'alias':
						$item->flink = 'index.php?Itemid='.$item->params->get('aliasoptions');
						break;
					default:
						$item->flink = 'index.php?Itemid=' . $item->id;
						break;
				}
				if (strcasecmp(substr($item->flink, 0, 4), 'http') && (strpos($item->flink, 'index.php?') !== false)) {
					$item->flink = Route::_($item->flink, true, $itemParams->get('secure'));					
				}
				else {
					$item->flink = Route::_($item->flink);
				}
				$item->menu_image     = $itemParams->get('menu_image', '') ?
						htmlspecialchars($itemParams->get('menu_image', ''), ENT_COMPAT, 'UTF-8', false) : '';
			}
		}
		
		return array_values($items);
	}	
}
