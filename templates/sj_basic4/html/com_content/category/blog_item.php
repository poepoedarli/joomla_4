<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Content\Administrator\Extension\ContentComponent;
use Joomla\Component\Content\Site\Helper\RouteHelper;

// Create a shortcut for params.
$params = $this->item->params;
$canEdit = $this->item->params->get('access-edit');
$info    = $params->get('info_block_position', 0);

// Check if associations are implemented. If they are, define the parameter.
$assocParam = (Associations::isEnabled() && $params->get('show_associations'));

?>
<div class="item-img-box">
	<?php echo LayoutHelper::render('joomla.content.intro_image', $this->item); ?>
	<?php if ($params->get('show_category')) : ?>
		<?php echo LayoutHelper::render('joomla.content.info_block.category', array('item' => $this->item, 'params' => $params, 'position' => 'above')); ?>
	<?php endif; ?>
</div>
<div class="item-content">
	<?php if ($this->item->state == ContentComponent::CONDITION_UNPUBLISHED || strtotime($this->item->publish_up) > strtotime(Factory::getDate())
		|| (!is_null($this->item->publish_down) && strtotime($this->item->publish_down) < strtotime(Factory::getDate()))) : ?>
		<div class="system-unpublished">
	<?php endif; ?>

	<?php echo LayoutHelper::render('joomla.content.blog_style_default_item_title', $this->item); ?>

	<?php if ($canEdit) : ?>
		<?php echo LayoutHelper::render('joomla.content.icons', array('params' => $params, 'item' => $this->item)); ?>
	<?php endif; ?>

	<?php // Todo Not that elegant would be nice to group the params ?>
	<?php $useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
		|| $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author') || $assocParam); ?>

	<?php if ($useDefList && ($info == 0 || $info == 2)) : ?>
		<?php echo LayoutHelper::render('joomla.content.info_block', array('item' => $this->item, 'params' => $params, 'position' => 'above')); ?>
	<?php endif; ?>
	<?php if ($info == 0 && $params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
		<?php echo LayoutHelper::render('joomla.content.tags', $this->item->tags->itemTags); ?>
	<?php endif; ?>

	<?php if (!$params->get('show_intro')) : ?>
		<?php // Content is generated by content plugin event "onContentAfterTitle" ?>
		<?php echo $this->item->event->afterDisplayTitle; ?>
	<?php endif; ?>

	<?php // Content is generated by content plugin event "onContentBeforeDisplay" ?>
	<?php echo $this->item->event->beforeDisplayContent; ?>

	<?php echo $this->item->introtext; ?>

	<?php if ($info == 1 || $info == 2) : ?>
		<?php if ($useDefList) : ?>
			<?php echo LayoutHelper::render('joomla.content.info_block', array('item' => $this->item, 'params' => $params, 'position' => 'below')); ?>
		<?php endif; ?>
		<?php if ($params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
			<?php echo LayoutHelper::render('joomla.content.tags', $this->item->tags->itemTags); ?>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ($params->get('show_readmore') && $this->item->readmore) :
		if ($params->get('access-view')) :
			$link = Route::_(RouteHelper::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language));
		else :
			$menu = Factory::getApplication()->getMenu();
			$active = $menu->getActive();
			$itemId = $active->id;
			$link = new Uri(Route::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false));
			$link->setVar('return', base64_encode(RouteHelper::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language)));
		endif; ?>

		<?php echo LayoutHelper::render('joomla.content.readmore', array('item' => $this->item, 'params' => $params, 'link' => $link)); ?>

	<?php endif; ?>

	<?php if ($this->item->state == ContentComponent::CONDITION_UNPUBLISHED || strtotime($this->item->publish_up) > strtotime(Factory::getDate())
		|| (!is_null($this->item->publish_down) && strtotime($this->item->publish_down) < strtotime(Factory::getDate()))) : ?>
	</div>
	<?php endif; ?>
</div>

<?php // Content is generated by content plugin event "onContentAfterDisplay" ?>
<?php echo $this->item->event->afterDisplayContent; ?>
