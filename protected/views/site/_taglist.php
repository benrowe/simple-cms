<div class="tags">
	<h3>Tags</h3>
	<ul class="tag-list">
	<?php foreach ($tags as $tag): ?>
		<li><?php echo CHtml::link($tag, array('site/tag', 'tags' => $tag)); ?></li>
	<?php endforeach; ?>
	</ul>
</div>