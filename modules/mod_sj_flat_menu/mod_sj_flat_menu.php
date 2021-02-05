<?php
/**
 * @package Sj Flat Menu
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2016 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 */

defined('_JEXEC') or die;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\Module\Menu\Site\Helper\MenuHelper;
use Joomla\CMS\Factory;

if(!isset($params) || !(count($params) > 0)) return;

if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

require_once dirname(__FILE__).'/core/helper.php';

$layout = $params->get('layout', 'default');
$cacheid = md5(serialize(array ($layout, $module->id)));
$cacheparams = new stdClass;
$cacheparams->cachemode = 'id';
$cacheparams->class = 'FlatMenuHelper';
$cacheparams->method = 'getList';
$cacheparams->methodparams = $params;
$cacheparams->modeparams = $cacheid;
$menus = JModuleHelper::moduleCache ($module, $params, $cacheparams);
$type_menu = $params->get('type_menu');
$imagesURI = JURI::base()."modules/".$module->module."/assets/images";
$icon_normal = $imagesURI."/icon_active.png";
$icon_active = $imagesURI."/icon_normal.png";
$default    = MenuHelper::getDefault();
$itemID = $default->id;

//get itemID active
$app = Factory::getApplication();
$itemID = $app->input->getCmd('Itemid', '');

require JModuleHelper::getLayoutPath($module->module, $layout);
require JModuleHelper::getLayoutPath($module->module, $layout.'_js');
?>