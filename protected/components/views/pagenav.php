<div class="page-nav">
<?php if ($index > 1): ?>
<?php echo CHtml::link('&lt; Previous Page ('.$pages[$index-2]->title.')', array_merge($url, array('page' => $index-1)), array('class' => 'prev-page')); ?>
<?php endif; ?>


	<ul class="page-list">
	<?php foreach($pages as $i=>$page): ?>
		<li class="<?php echo $i === $index-1 ? 'current-page' : ''; ?>"><?php echo CHtml::link($page->title, array_merge($url, array('page' => $i+1))); ?></li>
	<?php endforeach; ?>
	</ul>
<?php if ($index < count($pages)): ?>
<?php echo CHtml::link('('. $pages[$index]->title.') next page &gt;', array_merge($url, array('page' => $index+1)), array('class'=>'next-page')); ?>
<?php endif; ?>
</div>