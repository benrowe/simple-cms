<div class="thumbnails">
	<h3>Image List</h3>
	<ul class="image-list-preview">
	<?php foreach ($images as $i=>$image): ?>
		<?php $class = $i === $index-1 ? 'selected' : ''; ?>
		<li class="<?php echo $class; ?>">
			<?php $this->widget('application.components.Image', array(
				'image' => $image,
				'class' => $class,
				'href'	=> '?index='.($i+1)
			)); ?>
		</li>
	<?php endforeach; ?>
	</ul>
</div>