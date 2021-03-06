<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_tags
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Tags\Site\Helper\RouteHelper;

HTMLHelper::_('behavior.core');

HTMLHelper::_('script', 'com_tags/tag-default.js', ['version' => 'auto', 'relative' => true]);

// Get the user object.
$user = Factory::getUser();

// Check if user is allowed to add/edit based on tags permissions.
// Do we really have to make it so people can see unpublished tags???
$canEdit      = $user->authorise('core.edit', 'com_tags');
$canCreate    = $user->authorise('core.create', 'com_tags');
$canEditState = $user->authorise('core.edit.state', 'com_tags');
?>
<form action="<?php echo htmlspecialchars(Uri::getInstance()->toString()); ?>" method="post" name="adminForm" id="adminForm" class="com-tags-tag__items">
	<?php if ($this->params->get('show_headings') || $this->params->get('filter_field') || $this->params->get('show_pagination_limit')) : ?>
		<fieldset class="com-tags-tag__filters filters d-flex justify-content-between mb-3">
			<?php if ($this->params->get('filter_field')) : ?>
				<div class="input-group">
					<label class="filter-search-lbl sr-only" for="filter-search">
						<?php echo Text::_('COM_TAGS_TITLE_FILTER_LABEL') . '&#160;'; ?>
					</label>
					<input type="text" name="filter-search" id="filter-search" value="<?php echo $this->escape($this->state->get('list.filter')); ?>" class="form-control" title="<?php echo Text::_('COM_TAGS_FILTER_SEARCH_DESC'); ?>" placeholder="<?php echo Text::_('COM_TAGS_TITLE_FILTER_LABEL'); ?>">
					<span class="input-group-append">
						<button type="submit" name="filter-search-button" title="<?php echo Text::_('JSEARCH_FILTER_SUBMIT'); ?>" class="btn btn-secondary">
							<span class="fas fa-search" aria-hidden="true"></span>
						</button>
						<button type="reset" name="filter-clear-button" title="<?php echo Text::_('JSEARCH_FILTER_CLEAR'); ?>" class="btn btn-secondary">
							<span class="fas fa-times" aria-hidden="true"></span>
						</button>
					</span>
				</div>
			<?php endif; ?>
			<?php if ($this->params->get('show_pagination_limit')) : ?>
				<div class="btn-group float-right">
					<label for="limit" class="sr-only">
						<?php echo Text::_('JGLOBAL_DISPLAY_NUM'); ?>
					</label>
					<?php echo $this->pagination->getLimitBox(); ?>
				</div>
			<?php endif; ?>

			<input type="hidden" name="filter_order" value="">
			<input type="hidden" name="filter_order_Dir" value="">
			<input type="hidden" name="limitstart" value="">
			<input type="hidden" name="task" value="">
		</fieldset>
	<?php endif; ?>

	<?php if (empty($this->items)) : ?>
		<p><?php echo Text::_('COM_TAGS_NO_ITEMS'); ?></p>
	<?php else : ?>
		<ul class="com-tags-tag__category category list-group">
			<?php foreach ($this->items as $i => $item) : ?>
				<?php if ($item->core_state == 0) : ?>
					<li class="list-group-item-danger">
				<?php else : ?>
					<li class="list-group-item list-group-item-action">
				<?php endif; ?>
				<?php if (($item->type_alias === 'com_users.category') || ($item->type_alias === 'com_banners.category')) : ?>
					<h3>
						<?php echo $this->escape($item->core_title); ?>
					</h3>
				<?php else : ?>
					<h3>
						<a href="<?php echo Route::_($item->link); ?>">
							<?php echo $this->escape($item->core_title); ?>
						</a>
					</h3>
				<?php endif; ?>
				<?php // Content is generated by content plugin event "onContentAfterTitle" ?>
				<?php echo $item->event->afterDisplayTitle; ?>
				<?php $images  = json_decode($item->core_images); ?>
				<?php if ($this->params->get('tag_list_show_item_image', 1) == 1 && !empty($images->image_intro)) : ?>
					<a href="<?php echo Route::_(RouteHelper::getItemRoute($item->content_item_id, $item->core_alias, $item->core_catid, $item->core_language, $item->type_alias, $item->router)); ?>">
						<img src="<?php echo htmlspecialchars($images->image_intro); ?>"
							alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>">
					</a>
				<?php endif; ?>
				<?php if ($this->params->get('tag_list_show_item_description', 1)) : ?>
					<?php // Content is generated by content plugin event "onContentBeforeDisplay" ?>
					<?php echo $item->event->beforeDisplayContent; ?>
					<span class="tag-body">
						<?php echo HTMLHelper::_('string.truncate', $item->core_body, $this->params->get('tag_list_item_maximum_characters')); ?>
					</span>
					<?php // Content is generated by content plugin event "onContentAfterDisplay" ?>
					<?php echo $item->event->afterDisplayContent; ?>
				<?php endif; ?>
					</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</form>
