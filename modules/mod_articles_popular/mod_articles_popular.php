<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_popular
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\Module\ArticlesPopular\Site\Helper\ArticlesPopularHelper;

$list = ArticlesPopularHelper::getList($params);

require ModuleHelper::getLayoutPath('mod_articles_popular', $params->get('layout', 'default'));