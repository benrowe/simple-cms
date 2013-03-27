<?php

$limit = 10;
$wm  = new WebManager;
$latest = $wm->getLatestItems($limit);

$this->beginWidget('bootstrap.widgets.BootHero', array(
	'heading' => 'Welcome'
));



?>
<p>Lets start with one of the following!</p>
	<?php 
	$this->widget('bootstrap.widgets.BootButton', array(
    'type'=>'primary', 
    'icon'=>'file white', 
    'label'=>'Items',
	'size' => 'large',
	'url' => array('items/index'),
)); 
	echo ' ';
	$this->widget('bootstrap.widgets.BootButton', array(
    //'type'=>'primary', 
    'icon'=>'plus', 
    'label'=>'Add Item',
	'size' => 'large',
	'url' => array('items/add'),
)); 
	echo ' ';
	$this->widget('bootstrap.widgets.BootButton', array(
    'type'=>'', 
    'icon'=>'user', 
    'label'=>'Users',
	'size' => 'large',
	'url' => array('users/index'),
)); 
		echo ' ';
	$this->widget('bootstrap.widgets.BootButton', array(
    'type'=>'', 
    'icon'=>'th-large', 
    'label'=>'Content Types',
	'size' => 'large',
	'url' => array('contenttypes/index'),
)); 
	?>
<?php $this->endWidget(); ?>

<div class="row">
	<div class="span4">
		<?php $this->beginWidget('zii.widgets.CPortlet', array(
			'title' => 'Latest'
		)); 
				$this->widget('zii.widgets.CListView', array(
					'itemsCssClass' => 'items-mini',
					'template' => '{items}',
					'dataProvider' => new CArrayDataProvider($latest->toArray()),
					'itemView' => '_dashboardItem'
				));
		
		?>
		<?php $this->endWidget(); ?>
	</div>
	<!--<div class="span4">
		<?php $this->beginWidget('zii.widgets.CPortlet', array(
			'title' => 'Most Popular'
		)); ?>
		<?php $this->endWidget(); ?>
	</div>
	<div class="span4">
		<?php $this->beginWidget('zii.widgets.CPortlet', array(
			'title' => 'Latest'
		)); ?>
		<?php $this->endWidget(); ?>
	</div>-->
</div>

