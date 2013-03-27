<div class="image <?php echo $class; ?>">
	<h3><?php echo $image['title']; ?></h3>
	<a href="<?php echo $href; ?>"><img src="<?php echo Yii::app()->request->baseUrl.'/'.$image['file']; ?>" alt="<?php echo $image['title']; ?>"></a>
	<div class="caption"><?php echo $image['description']; ?></div>
</div>