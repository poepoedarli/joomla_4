<?php
/*
 * ------------------------------------------------------------------------
 * Copyright (C) 2009 - 2013 The YouTech JSC. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: The YouTech JSC
 * Websites: http://www.smartaddons.com - http://www.cmsportal.net
 * ------------------------------------------------------------------------
*/

 // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

use Joomla\CMS\Component\ComponentHelper;

Class YT_Field_Shortcodes{

public static function formField($id,$field=array())
	{		
		$user = JFactory::getUser();

		$html = '';
		$type = $field['type'];
		switch ($type)
		{
/* ------------------------------------------------------#media-------------------------------------------- */
			case 'media':
				$html .= '<div class="yt-generator-icon-picker-wrapper">
							<div class="controls">
								<joomla-field-media class="field-media-wrapper"
									type="image"
									base-path="'.JURI::root().'"
									root-folder="images"
									url="index.php?option=com_media&tmpl=component&asset=&author=&fieldid={field-media-id}&path="
									modal-container=".modal"
									modal-width="100%"
									modal-height="400px"
									input=".yt-generator-attr-' . $id . '"
									button-select=".button-select"
									button-clear=".button-clear"
									button-save-selected=".button-save-selected"
									preview="static"
									preview-container=".field-media-preview"
									preview-width="200"
									preview-height="200"
								>
									<div id="imageModal_'.$id.'" role="dialog" tabindex="-1" class="joomla-modal modal fade" data-url="index.php?option=com_media&amp;tmpl=component&amp;asset=com_contact&amp;author=&amp;fieldid={field-media-id}&amp;path=" data-iframe="&lt;iframe class=&quot;iframe&quot; src=&quot;index.php?option=com_media&amp;amp;tmpl=component&amp;amp;asset=com_contact&amp;amp;author=&amp;amp;fieldid={field-media-id}&amp;amp;path=&quot; name=&quot;Change Image&quot; height=&quot;100%&quot; width=&quot;100%&quot;&gt;&lt;/iframe&gt;">
										<div class="modal-dialog modal-lg jviewport-width60" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h3 class="modal-title">Change Image</h3>
													<button type="button" class="close novalidate" data-dismiss="modal">&times;</button>
												</div>
												<div class="modal-body jviewport-height60">
													<iframe class="iframe" src="index.php?option=com_media&tmpl=component&asset=&author=&fieldid={field-media-id}&path=" name="Change Image" height="100%" width="100%"></iframe>
												</div>
												<div class="modal-footer" style="background-color: #fff; text-align: right; padding: 15px; border-top: 0;">
													<button class="btn btn-secondary button-save-selected">Select</button>
												</div>
											</div>
										</div>
									</div>
									<div class="field-media-preview" style="height:auto; display: none;">
									 	<div id="jform_images_image_intro_preview_empty" style="display:none">No image selected.</div>
									 	<div id="jform_images_image_intro_preview_img"><img src="" alt="Selected image." class="media-preview" style="max-width:200px;max-height:200px;"></div>
								 	</div>
									<div class="input-group">
										<input type="text" name="' . $id . '" value="' . htmlentities( $field['default'] ) . '" id="yt-generator-attr-' . $id . '" class="yt-generator-attr-'.$id.' yt-generator-attr yt-generator-upload-value" />
										<div class="input-group-btn yt-generator-field-actions">
											<a class="yt_btn yt_btn-primary button-select yt-generator-attr-src-a" title="Select image source">
												<i class="fa fa-image"></i>Select media
											</a>
										</div>
									</div>
								</joomla-field-media>
							</div>
						</div>';
			break;

/* ------------------------------------------------------#text-------------------------------------------- */
			case 'text':
				$html .= '<input type="text" name="' . $id . '" value="' . $field['default'] . '" id="yt-generator-attr-' . $id . '" class="yt-generator-attr" />';
			break;

/* ------------------------------------------------------#textarea-------------------------------------------- */
			case 'textarea':
				$html = '<textarea name="' . $id . '" id="yt-generator-attr-' . $id . '" rows="3" class="yt-generator-attr">' .  $field['default']  . '</textarea>';
			break;

/* ------------------------------------------------------#color-------------------------------------------- */
			case 'color':
				$html .= '<span class="yt-generator-select-color"><span class="yt-generator-select-color-wheel"></span><input type="text" name="' . $id . '" value="' . $field['default'] . '" id="yt-generator-attr-' . $id . '" class="yt-generator-attr yt-generator-select-color-value" /> </span>';
			break;

/* ------------------------------------------------------#select-------------------------------------------- */
			case 'select':
				$multiple = ( isset( $field['multiple'] ) ) ? ' multiple' : '';
				$class = (isset($field['class'])) ? $field['class'] : '';
				$html .= "<select name='" . $id . "' id='yt-generator-attr-" . $id . "' class='yt-generator-attr ".$class."'" . $multiple . " >";

				foreach($field['values'] as $option_value => $option_title){
					$selected = ( $field['default'] == $option_value ) ? ' selected="selected"' : '';
						$html .= '<option value="'.$option_value.'" ' . $selected . '>'.$option_title.'</option>';
					}
				$html .= "</select>";
			break;

/* -------------------------------------------------------#bool-------------------------------------------- */
			case 'bool':
				$html .= '<span class="yt-generator-switch yt-generator-switch-' . $field['default'] . '"><span class="yt-generator-yes">Yes</span><span class="yt-generator-no">No</span></span><input type="hidden" name="' . $id . '" value="' . $field['default'] . '" id="yt-generator-attr-' . $id . '" class="yt-generator-attr yt-generator-switch-value" />';
			break;

/* ------------------------------------------------------#slider-------------------------------------------- */
			case 'slider':
				$html .= '<div class="yt-generator-range-picker yt-generator-clearfix"><input type="number" name="' . $id . '" value="' . $field['default'] . '" id="yt-generator-attr-' . $id . '" min="' . $field['min'] . '" max="' . $field['max'] . '" step="' . $field['step'] . '" class="yt-generator-attr" /></div>';
			break;

/* ------------------------------------------------------#border-------------------------------------------- */
			case 'border':
				$defaults = ($field['default'] === 'none' ) ? array ('0', 'solid', '#000000') : explode(' ', str_replace( 'px', '', $field['default']));
				$border = array(
					'none' => "None",
					'solid' => "Solid",
					'dotted' => "Dotted",
					'dashed' => "Dashed",
					'double' => "Double",
					'groove' => "Groove",
					'ridge' => "Ridge",
				);
				$borders ='';
					$borders .= '<select class="yt-generator-bp-style">';
					foreach ($border as $option_value => $option_title)
					{
						$selected = ($defaults[1] == $option_value) ? 'selected' : '';
						$borders .= '<option value="'.$option_value.'" '.$selected.'>'.$option_title.'</option>';
					}
					$borders .='</select>';
					$html .= '<div class="yt-generator-border-picker"><span class="yt-generator-border-picker-field"><input type="number" min="-1000" max="1000" step="1" value="'.$defaults[0].'" class="yt-generator-bp-width" /><small>Border width (px)</small></span><span class="yt-generator-border-picker-field">' . $borders . '<small> Border style</small></span><span class="yt-generator-border-picker-field yt-generator-border-picker-color"><span class="yt-generator-border-picker-color-wheel"></span><input type="text" value="'.$defaults[2].'" class="yt-generator-border-picker-color-value" /><small>Border color</small></span><input type="hidden" name="' . $id . '" value="' .  $field['default'] . '" id="yt-generator-attr-' . $id . '" class="yt-generator-attr" /></div>';
			break;

/* -----------------------------------------------------#shadow-------------------------------------------- */
			case 'shadow':
				$defaults = ( $field['default'] === 'none' ) ? array ('0', '0', '0', '#000000') : explode(' ', str_replace( 'px', '', $field['default']));
				$html .= '<div class="yt-generator-shadow-picker"><span class="yt-generator-shadow-picker-field"><input type="number" min="-1000" max="1000" step="1" value="' . $defaults[0] . '" class="yt-generator-sp-hoff" /><small>Horizontal offset (px)</small></span><span class="yt-generator-shadow-picker-field"><input type="number" min="-1000" max="1000" step="1" value="' . $defaults[1] . '" class="yt-generator-sp-voff" /><small>Vertical offset (px)</small></span><span class="yt-generator-shadow-picker-field"><input type="number" min="-1000" max="1000" step="1" value="' . $defaults[2] . '" class="yt-generator-sp-blur" /><small>Blur (px)</small></span><span class="yt-generator-shadow-picker-field yt-generator-shadow-picker-color"><span class="yt-generator-shadow-picker-color-wheel"></span><input type="text" value="' . $defaults[3] . '" class="yt-generator-shadow-picker-color-value" /><small>Color</small></span><input type="hidden" name="' . $id . '" value="' .  $field['default']  . '" id="yt-generator-attr-' . $id . '" class="yt-generator-attr" /></div>';
			break;

/* ------------------------------------------------------#number-------------------------------------------- */
			case 'number':
				$html .= '<input type="number" name="' . $id . '" value="' . $field['default'] . '" id="yt-generator-attr-' . $id . '" min="' . $field['min'] . '" max="' . $field['max'] . '" step="' . $field['step'] . '" class="yt-generator-attr" />';
			break;

/* ------------------------------------------------------#note-------------------------------------------- */
			case 'note':
				$html .= '<span>' . $field['default']  . '</span><input style="display: none;" type="text" name="' . $id . '" value="' .  $field['default']  . '" id="yt-generator-attr-' . $id . '" class="yt-generator-attr" />';
			break;

/* -------------------------------------------------------#icon-------------------------------------------- */
			case 'icon':
				$icons = YT_Data::icons();
				$html .= '<div class="yt-generator-icon-picker-wrapper">
							<div class="controls">
								<joomla-field-media class="field-media-wrapper"
									type="image"
									base-path="'.JURI::root().'"
									root-folder="images"
									url="index.php?option=com_media&tmpl=component&asset=&author=&fieldid={field-media-id}&path="
									modal-container=".modal"
									modal-width="100%"
									modal-height="400px"
									input=".yt-generator-attr-' . $id . '"
									button-select=".button-select"
									button-clear=".button-clear"
									button-save-selected=".button-save-selected"
									preview="static"
									preview-container=".field-media-preview"
									preview-width="200"
									preview-height="200"
								>
									<div id="imageModal_'.$id.'" role="dialog" tabindex="-1" class="joomla-modal modal fade" data-url="index.php?option=com_media&amp;tmpl=component&amp;asset=com_contact&amp;author=&amp;fieldid={field-media-id}&amp;path=" data-iframe="&lt;iframe class=&quot;iframe&quot; src=&quot;index.php?option=com_media&amp;amp;tmpl=component&amp;amp;asset=com_contact&amp;amp;author=&amp;amp;fieldid={field-media-id}&amp;amp;path=&quot; name=&quot;Change Image&quot; height=&quot;100%&quot; width=&quot;100%&quot;&gt;&lt;/iframe&gt;">
										<div class="modal-dialog modal-lg jviewport-width60" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h3 class="modal-title">Change Image</h3>
													<button type="button" class="close novalidate" data-dismiss="modal">&times;</button>
												</div>
												<div class="modal-body jviewport-height60">
													<iframe class="iframe" src="index.php?option=com_media&tmpl=component&asset=&author=&fieldid={field-media-id}&path=" name="Change Image" height="100%" width="100%"></iframe>
												</div>
												<div class="modal-footer" style="background-color: #fff; text-align: right; padding: 15px; border-top: 0;">
													<button class="btn btn-secondary button-save-selected">Select</button>
												</div>
											</div>
										</div>
									</div>
									<div class="field-media-preview" style="height:auto; display: none;">
									 	<div id="jform_images_image_intro_preview_empty" style="display:none">No image selected.</div>
									 	<div id="jform_images_image_intro_preview_img"><img src="" alt="Selected image." class="media-preview" style="max-width:200px;max-height:200px;"></div>
								 	</div>
									<div class="input-group">
										<input type="text" name="' . $id . '" value="' .  $field['default']  . '" id="yt-generator-attr-' . $id . '" class="yt-generator-attr-' . $id . ' yt-generator-attr yt-generator-icon-picker-value" />
										<div class="input-group-btn yt-generator-field-actions">
											<a class="yt_btn yt_btn-primary button-select yt-generator-attr-' . $id . '-a" title="Select image">
												<i class="fa fa-image"></i>Select image
											</a>
											<a href="javascript:;" class="yt_btn yt_btn-warning yt-generator-icon-picker-button yt-generator-field-action">
						 						<i class="fa fa-magic"></i>Icon picker
						 					</a>
										</div>
									</div>
								</joomla-field-media>
							</div>
						</div>
						<div class="yt-generator-icon-picker yt-generator-clearfix ">
							<input type="text" class="yt-icon-picker-search" placeholder="Filter Icons" />';
							foreach($icons as $icon)
							{
								$html .='<i style="display: block;" class="fa fa-'.$icon.'" title="'.$icon.'"></i>';
							}
				$html .= '</div>';			
			break;

/* ------------------------------------------------------#livicon-------------------------------------------- */
			case 'livicon':
				$livicons = YT_Data::livicons();
				$html .= '<select name="icon" id="yt-generator-attr-icon" class="yt-generator-attr">';

				foreach ($livicons as $livicon)
				{
					$selected = ($livicon == $field['default'] ) ? ' selected="selected"' : '';
					$html .= '<option value="'.$livicon.'" ' . $selected . '>'.$livicon.'</option>';
				}
				$html .= '</select>';
			break;

/* ------------------------------------------------------#source-------------------------------------------- */
			case 'source':
				$sources = "<select class='yt-generator-isp-sources'>";
				$sources .= '<option value="media" >Media</option>';
				$sources .= '<option value="category" >Category</option>';
				if (JComponentHelper::isEnabled('com_k2', true) && JComponentHelper::isEnabled('com_virtuemart', true)) {
					$sources .= '<option value="k2-category">K2-category</option>';
					$sources .= '<option value="vm-category">VM-category</option>';
				}elseif(JComponentHelper::isEnabled('com_k2', true)){
					$sources .= '<option value="k2-category">K2-category</option>';
				}elseif(JComponentHelper::isEnabled('com_virtuemart', true)){
					$sources .= '<option value="vm-category">VM-category</option>';
				}
				$sources .= "</select>";

				//Select  content
				$categories = '<select class="yt-generator-isp-categories" multiple>';
					foreach (get_terms( 'category' ) as $option_value => $option_title)
					{
						$categories .= '<option value="'.$option_value.'">'.$option_title.'</option>';
					}
				//Select k2
				$categories .= '</select>';
				if (JComponentHelper::isEnabled('com_k2', true)) {
					$k2_categories = '<select class="yt-generator-isp-k2-categories" multiple>';
					foreach (get_k2_terms( 'k2-category' ) as $option_value => $option_title)
					{
						$k2_categories .= '<option value="'.$option_value.'">'.$option_title.'</option>';
					}
					$k2_categories .= '</select>';
				} else {
					$k2_categories = null;
				}
				//Select com_virtuemart
				$categories .= '</select>';
				if (JComponentHelper::isEnabled('com_virtuemart', true)) {
					$vm_categories = '<select class="yt-generator-isp-vm-categories" multiple>';
					foreach (get_vm_terms( 'vm-category' ) as $option_value => $option_title)
					{
						$vm_categories .= '<option value="'.$option_value.'">'.$option_title.'</option>';
					}
					$vm_categories .= '</select>';
				} else {
					$vm_categories = null;
				}
				$html  .= '<div class="yt-generator-isp">' . $sources;
					$html .= '<div class="yt-generator-isp-source yt-generator-isp-source-media">';
		        		$html .= '<div class="yt-generator-clearfix">';
		        			$html .= '<div class="yt-generator-icon-picker-wrapper">
							<div class="controls">
								<joomla-field-media class="field-media-wrapper"
									type="image"
									base-path="'.JURI::root().'"
									root-folder="images"
									url="index.php?option=com_media&tmpl=component&asset=&author=&fieldid={field-media-id}&path="
									modal-container=".modal"
									modal-width="100%"
									modal-height="400px"
									input=".yt-generator-isp-images"
									button-select=".button-select"
									button-clear=".button-clear"
									button-save-selected=".button-save-selected"
									preview="static"
									preview-container=".field-media-preview"
									preview-width="200"
									preview-height="200"
								>
									<div id="imageModal_'.$id.'" role="dialog" tabindex="-1" class="joomla-modal modal fade" data-url="index.php?option=com_media&amp;tmpl=component&amp;asset=com_contact&amp;author=&amp;fieldid={field-media-id}&amp;path=" data-iframe="&lt;iframe class=&quot;iframe&quot; src=&quot;index.php?option=com_media&amp;amp;tmpl=component&amp;amp;asset=com_contact&amp;amp;author=&amp;amp;fieldid={field-media-id}&amp;amp;path=&quot; name=&quot;Change Image&quot; height=&quot;100%&quot; width=&quot;100%&quot;&gt;&lt;/iframe&gt;">
										<div class="modal-dialog modal-lg jviewport-width60" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h3 class="modal-title">Change Image</h3>
													<button type="button" class="close novalidate" data-dismiss="modal">&times;</button>
												</div>
												<div class="modal-body jviewport-height60">
													<iframe class="iframe" src="index.php?option=com_media&tmpl=component&asset=&author=&fieldid={field-media-id}&path=" name="Change Image" height="100%" width="100%"></iframe>
												</div>
												<div class="modal-footer" style="background-color: #fff; text-align: right; padding: 15px; border-top: 0;">
													<button class="btn btn-secondary button-save-selected">Select</button>
												</div>
											</div>
										</div>
									</div>
									<div class="field-media-preview" style="height:auto; display: none;">
									 	<div id="jform_images_image_intro_preview_empty" style="display:none">No image selected.</div>
									 	<div id="jform_images_image_intro_preview_img"><img src="" alt="Selected image." class="media-preview" style="max-width:200px;max-height:200px;"></div>
								 	</div>
									<div class="input-group">
										<div class="input-group-btn yt-generator-field-actions">
											<a class="yt_btn yt_btn-primary button-select yt-generator-isp-add-media" title="Select image">
												<i class="fa fa-plus"></i>&nbsp;&nbsp;Add image
											</a>
										</div>
									</div>
									<div id="yt-generator-attr-image" class="yt-generator-isp-images yt-generator-clearfix">
									</div>
								</joomla-field-media>
							</div>
						</div>';


		        // 			$html .= '<a class="yt_btn button button-primary yt-generator-isp-add-media" title="Select image" onClick="SqueezeBox.fromElement(this, {handler:\'iframe\', size: {x: 830, y: 600}}); return false;" href="index.php?option=com_media&tmpl=component&asset=&author=&fieldid=yt-generator-attr-source&folder=" rel="{handler: \'iframe\', size: {x: 830, y: 600}}">';
		        // 				$html .= '<i class="fa fa-plus"></i>&nbsp;&nbsp;Add image';
		    				// $html .= '</a>';


		        		$html .= '</div>';
						$html .= '<div id="yt-generator-attr-image" class="yt-generator-isp-images yt-generator-clearfix">';
							$html .= '<em class="description">Click the button above and select images.</em>';
						$html .= '</div>';
					$html .= '</div>';
					$html .= '<div class="yt-generator-isp-source yt-generator-isp-source-category">';
						$html .= '<em class="description">Select category from list below.<br>You can select multiple category with Ctrl (Cmd) key</em>';
						$html .= $categories;
					$html .= '</div>';
					$html .= '<div class="yt-generator-isp-source yt-generator-isp-source-k2-category">';
						$html .= '<em class="description">Select K2 category from list below.<br>You can select multiple category with Ctrl (Cmd) key</em>';
						$html .= $k2_categories;
					$html .= '</div>';
					$html .= '<div class="yt-generator-isp-source yt-generator-isp-source-vm-category">';
						$html .= '<em class="description">Select VM category from list below.<br>You can select multiple category with Ctrl (Cmd) key</em>';
						$html .= $vm_categories;
					$html .= '</div>';
					$html .= '<input type="hidden" name="' . $id . '" value="' . $field['default'] . '" id="yt-generator-attr-' . $id . '" class="yt-generator-attr" />';
				$html .= '</div>';
			break;

/* ---------------------------------------------------#addElement-------------------------------------------- */
			case 'addElement':
				return '';
			break;

/* ---------------------------------------------------#addElement-------------------------------------------- */
			case 'module':
				$multiple = ( isset( $field['multiple'] ) ) ? ' multiple' : '';
				$class = (isset($field['class'])) ? $field['class'] : '';
				$html .= "<select name='" . $id . "' id='yt-generator-attr-" . $id . "' class='yt-generator-attr ".$class."'" . $multiple . " >";
				$db = JFactory::getDBO();
				$document	= JFactory::getDocument();
				$query = "SELECT * FROM #__modules WHERE published = 1 AND position != '' ";
				$db->setQuery($query);
				$result = $db->loadObjectList();
				foreach($result as $item){
					$selected = ( $field['default'] === $item->title ) ? ' selected="selected"' : '';
					$html .= '<option value="'.$item->title.'" ' . $selected . '>'.$item->title.'</option>';
				}
				$html .= "</select>";
				break;

/* -----------------------------------------------#article_source-------------------------------------------- */
			case 'article_source':

				$sources = "<select class='yt-generator-isp-sources'>";
				$sources .= '<option value="category" >Category</option>';
				if (JComponentHelper::isEnabled('com_k2', true) && JComponentHelper::isEnabled('com_virtuemart', true)) {
					$sources .= '<option value="k2-category" >K2-category</option>';
					$sources .= '<option value="vm-category" >VM-category</option>';
				}elseif (JComponentHelper::isEnabled('com_k2', true)){
					$sources .= '<option value="k2-category" >K2-category</option>';
				}elseif (JComponentHelper::isEnabled('com_virtuemart', true)){
					$sources .= '<option value="vm-category" >VM-category</option>';
				}
				$sources .= "</select>";

				$categories = '<select class="yt-generator-isp-categories" multiple>';
					foreach (get_terms( 'category' ) as $option_value => $option_title)
					{
						$categories .= '<option value="'.$option_value.'">'.$option_title.'</option>';
					}

				$categories .= '</select>';
				if (JComponentHelper::isEnabled('com_k2', true)) {
					$k2_categories = '<select class="yt-generator-isp-k2-categories" multiple>';
					foreach (get_k2_terms( 'k2-category' ) as $option_value => $option_title)
					{
						$k2_categories .= '<option value="'.$option_value.'">'.$option_title.'</option>';
					}
					$k2_categories .= '</select>';
				} else {
					$k2_categories = null;
				}

				if (JComponentHelper::isEnabled('com_virtuemart', true)) {
					$vm_categories = '<select class="yt-generator-isp-vm-categories" multiple>';
					foreach (get_vm_terms( 'vm-category' ) as $option_value => $option_title)
					{
						$vm_categories .= '<option value="'.$option_value.'">'.$option_title.'</option>';
					}
					$vm_categories .= '</select>';
				} else {
					$vm_categories = null;
				}

				$return  = '<div class="yt-generator-isp">' . $sources;
					$return .= '<div class="yt-generator-isp-source yt-generator-isp-source-category">';
						$return .= '<em class="description">' . JText::_('PLG_SYSTEM_YOUTECH_SHORTCODES_CATEGORY_DESC') . '</em>';
						$return .= $categories;
					$return .= '</div>';
					$return .= '<div class="yt-generator-isp-source yt-generator-isp-source-k2-category">';
						$return .= '<em class="description">' . JText::_('PLG_SYSTEM_YOUTECH_SHORTCODES_K2_CATEGORY_DESC'). '</em>';
						$return .= $k2_categories;
					$return .= '</div>';
					$return .= '<div class="yt-generator-isp-source yt-generator-isp-source-vm-category">';
						$return .= '<em class="description">' . JText::_('PLG_SYSTEM_YOUTECH_SHORTCODES_vm_CATEGORY_DESC'). '</em>';
						$return .= $vm_categories;
					$return .= '</div>';
					$return .= '<input type="hidden" name="' . $id . '" value="' . $field['default'] . '" id="yt-generator-attr-' . $id . '" class="yt-generator-attr" />';
				$return .= '</div>';
				return $return;
		}
		return $html;
	}

}
?>