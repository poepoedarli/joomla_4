<?php
/**
* @package Sj Basic News
* @version 3.0
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* @copyright (c) 2012 YouTech Company. All Rights Reserved.
* @author YouTech Company http://www.smartaddons.com
*
*/
defined('_JEXEC') or die;
// Load the FieldsHelper to override field
JLoader::register('FieldsHelper', JPATH_ADMINISTRATOR . '/components/com_fields/helpers/fields.php');

if(!empty($list)){
	$uniquied = 'sj_basic_news_'.time().rand();
	JHtml::stylesheet('modules/mod_sj_basic_news/assets/css/sj-basic-news.css');
	ImageHelper::setDefault($params);
?>
	

	<?php if($params->get('pretext') != null) {?>
		<div class="bs-pretext">
			<?php echo $params->get('pretext'); ?>
		</div>
	<?php }?>
	<div id="<?php echo $uniquied?>" class="sj-basic-news">
		<div class="bs-items">
			<?php  $i = 0;  foreach($list as $item){ $i++;
				$show_line = ($params->get('showline') == 1)?' bs-show-line':'';
				$last_class = ($i == count($list))?' last':'';
				$img = SjBasicNewsHelper::getAImage($item, $params);
				//print_r($item);
			?>
			
				<div class="bs-item cf <?php echo $show_line.' '.$last_class; ?>">
					<?php if($img){?>
					<div class="bs-image">
						<a href="<?php echo $item->link ?>" title="<?php echo $item->title; ?>" <?php echo SjBasicNewsHelper::parseTarget($params->get('link_target')); ?>>
							<?php
								 echo SjBasicNewsHelper::imageTag($img);
							?>
						</a>
						<?php if($params->get('cat_title_display') == 1){?>
						<div class="bs-cat">						
							<span class="bs-cat-title">
								<?php echo $item->category_title; ?>
							</span>					
						</div>						
						<?php }?>
						
						<?php
						//var_dump($item->jcfields);
						foreach($item->jcfields as $jcfield) :
							$item->jcFields[$jcfield->name] = $jcfield;
						
						//echo $item->jcFields['video']->label; 
						//echo $item->jcFields['video']->rawvalue; 
						?>
						<?php if($item->jcFields['video2']->rawvalue){?>
							<?php $id_video = ( preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $item->jcFields['video2']->rawvalue, $match) ) ? $match[1] : false; ?>
							<div class="bs-video">								
								<a data-toggle="modal" href="#videoModal<?php echo $i;?>"></a>
								<div id="videoModal<?php echo $i;?>" class="modal videoModal" tabindex="-1" role="dialog">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
										  <div class="modal-header">	
											<h5 class="modal-title" id="videoModalLabel<?php echo $i;?>"><?php echo $item->jcFields['video2']->label; ?></h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											  <span aria-hidden="true">&times;</span>
											</button>
										  </div>
										  <div class="modal-body">
											<iframe width="400" height="300" src="http://www.youtube.com/embed/<?php echo $id_video;?>"></iframe>
										  </div>										  
										</div>
									</div>
								</div>
							</div>	
						<?php } ?>
						<?php endforeach; ?>
						
					</div>
					<?php } ?>
					
					<div class="bs-content">
						<?php if($params->get('cat_title_display') == 1){?>
							<div class="bs-cat">						
								<span class="bs-cat-title">							
									<?php echo $item->category_title; ?>								
								</span>					
							</div>
						<?php }?>
						<?php if($params->get('title_display') == 1) {?>
						<div class="bs-title">
							<a href="<?php echo $item->link ?>" title="<?php echo $item->title; ?>" <?php echo SjBasicNewsHelper::parseTarget($params->get('link_target')); ?>>
								<?php echo SjBasicNewsHelper::truncate($item->title, $params->get('item_title_max_characs',25)); ?>
							</a>
						</div>
						<?php }?>
						<?php if($params->get('item_date_display') == 1 ){?>
							<div class="bs-author-date">	
								<span class="bs-author"><?php echo  $item->author; ?></span> - 
								<?php if($params->get('item_date_display') == 1 ){?>
								<span class="bs-date"><?php echo JHTML::_('date', $item->created, JText::_('M d, Y')); ?></span>
								<?php }?>
							</div>
						<?php }?>
						<?php if($params->get('item_desc_display') == 1) {?>
						<div class="bs-description">
							<?php echo SjBasicNewsHelper::truncate($item->introtext, $params->get('item_desc_max_characs',200)); ?>
						</div>
						<?php } ?>
						
						<?php if($params->get('item_readmore_display') == 1){?>
						<div class="bs-readmore">
							<a href="<?php echo $item->link ?>" title="<?php echo $item->title; ?>" <?php echo SjBasicNewsHelper::parseTarget($params->get('link_target')); ?>>
								<?php echo $params->get('item_readmore_text'); ?>
							</a>
						</div>
						<?php }?>
					</div>
				</div>
			
			<?php } ?>
		</div>
	</div>
	<?php if($params->get('posttext') != null) {?>
	<div class="bs-posttext">
		<?php echo $params->get('posttext'); ?>
	</div>
	<?php }?>


<?php 
}else{
	echo JText::_('Has no content to show!');	
}?>