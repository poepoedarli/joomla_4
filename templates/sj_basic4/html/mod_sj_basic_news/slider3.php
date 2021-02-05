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
//$count_item = $params->get('count', 'default');
$nb_rows=3;

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
	<div id="<?php echo $uniquied?>" class="sj-basic-news carousel slide" data-ride="carousel" data-interval="false">
		<!-- Left and right controls -->
		<div class="owl-nav">
			<a class="owl-prev carousel-control-prev" href="#<?php echo $uniquied?>" data-slide="prev">
				<span class="carousel-control-prev-icon"></span>
			</a>
			<a class="owl-next carousel-control-next" href="#<?php echo $uniquied?>" data-slide="next">
				<span class="carousel-control-next-icon"></span>
			</a>
		</div>
		<!-- Indicators -->	
		<ul class="carousel-indicators owl-dots">
		<?php $j = 0; $page = 0;
		    foreach ($list as $item){$j ++;
			    //$active_class = $page == 0 ? " active" : "";
			    if( $j%$nb_rows == 1){$page ++;?>
				<li class="page <?php if( $page==1 ){echo 'active';}?>" data-target="#<?php echo $uniquied?>" data-slide-to="<?php echo $page-1;?>"></li>			   
		    <?php }}?>
		</ul>
				
		<!-- The slideshow -->
		<div class="carousel-inner bs-items">
			<?php $i = 0;  foreach($list as $item){ $i++;
				$show_line = ($params->get('showline') == 1)?' bs-show-line':'';
				$last_class = ($i == count($list) || $i==$nb_rows)?' last':'';
				$img = SjBasicNewsHelper::getAImage($item, $params);
				//var_dump($item);
			?>
				<?php if ($i % $nb_rows == 1 || $nb_rows == 1) { ?>
				<div class="carousel-item <?php if($i==1){echo "active";}?>">
				<?php } ?>
					<div class="bs-item cf<?php echo $show_line.' '.$last_class; ?>">
						<?php if($img){ ?>
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
						</div>
						<?php } ?>
						<div class="carousel-caption bs-content">
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
				<?php if ($i % $nb_rows == 0 || $i == count($list)) { ?>
				</div>
				<?php } ?>
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