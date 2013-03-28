<?php

Yii::app()->clientScript->registerLinkTag('alternate', 'application/rss+xml', $this->createUrl($this->route, array('view' => 'rss')));

?>
<h3>Items</h3>
<span class="rss"><?php echo CHtml::link('rss', array_merge($this->url, array('view' => 'rss'))); ?></span>
<?php if (count($items) > 0): ?>
<ul class="item-list">
<?php foreach ($items as $item): ?>
	<li class="item">
		<h2><?php echo CHtml::link($item->title, array('site/item', 'slug' => $item->id, 'type' => $item->type), array('title' => $item->title)); ?></h2>
		<?php //echo CHtml::image(Yii::app()->request->baseUrl.'/'.$item->image, $item->title, array('class' => 'cover')); ?>
		<div class="description"><?php echo $item->description; ?></div>
		<?php //$this->renderPartial('_taglist', array('tags' => $item->tags)); ?>
	</li>
<?php endforeach; ?>
</ul>	
	<?php if (isset($pages)): ?>
		<div class="pagination">
			<?php $this->widget('CLinkPager', array(
				'pages' => $pages,
				'maxButtonCount' => '5',
				'header' => '',
				'cssFile' => false,
				'nextPageLabel' => 'next',
				'prevPageLabel' => 'prev',
			)); ?>
		</div>
	<?php endif; ?>
<?php else: ?>
<div class="no-results">No items available</div>
<?php endif; ?>