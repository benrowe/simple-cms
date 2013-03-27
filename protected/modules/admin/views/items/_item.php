<?php 
	/* @var $item WebItemBase */ 
	echo CHtml::openTag('div', array(
		'id' => 'item_'.$item->type.'_'.$item->id,
		'class' => implode(' ', array(
		'item',
		'item-'.$item->type,
		'id-'.$item->id,
		'published-'.($item->published ? 'true' : 'false'),
		'featured-'.($item->featured ? 'true' : 'false'),
		
	))));
?>
	<h3><?php echo CHtml::link($item->title, array('items/edit', 'type' => $type->id, 'id' => $item->id), array('class' => 'link-title')); ?></h3>
	<div class="description">
		<p><?php echo CHtml::encode($item->description); ?></p>
	</div>
	<dl>
		<dt class="publish-date">Publish Date</dt>
		<dd class="publish-date"><?php echo CHtml::encode($item->datePublished  ? $item->datePublished : 'N/A'); ?></dd>
		<dt class="created-date">Created Date</dt>
		<dd class="created-date"><?php echo CHtml::encode($item->dateCreated); ?></dd>
	</dl>
	<?php 
	
		if ($item->published) {
			$this->widget('bootstrap.widgets.BootLabel', array(
				'type'=>'success', // '', 'success', 'warning', 'important', 'info' or 'inverse'
				'label'=>'Published',
			));
			$pIcon = 'thumbs-down' ;
			$pLabel = 'Un-Publish';
			$pAction = 'items/unpublish';
		} else {
			$this->widget('bootstrap.widgets.BootLabel', array(
				'type'=>'inverse', // '', 'success', 'warning', 'important', 'info' or 'inverse'
				'label'=>'Draft',
			));
			$pIcon = 'thumbs-up' ;
			$pLabel = 'Publish';
			$pAction = 'items/publish';
		}
		//echo CHtml::link($label, array($action, 'type' => $type->id, 'id' => $item->id), array('class' => 'btn '.$cls));

		if ($item->featured) {
			$this->widget('bootstrap.widgets.BootLabel', array(
				'type'=>'warning', // '', 'success', 'warning', 'important', 'info' or 'inverse'
				'label'=>'Featured',
			));
			$fIcon = 'star-empty' ;
			$fLabel = 'Un-feature';
			$fAction = 'items/unfeature';
		} else {
			$fIcon = 'star' ;
			$fLabel = 'Feature';
			$fAction = 'items/feature';
		}
		//echo CHtml::link($label, array($action, 'type' => $type->id, 'id' => $item->id), array('class' => 'btn '.$cls));
			
		$this->widget('bootstrap.widgets.BootButtonGroup', array(
			//'type'=>'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
			'buttons'=>array(
				array('label'=>'Edit', 'icon' => 'pencil', 'url'=>array('items/edit', 'type' => $type->id, 'id' => $item->id)),
				array(
					'items'=>array(
						//array('label'=>'Edit'),
						array('label'=>'Preview', 'url'=> array('/site/item', 'type' => $type->id, 'slug' => $item->id), 'icon' => 'share-alt'),
						array('label'=>$pLabel, 'url'=> array($pAction, 'type' => $type->id, 'id' => $item->id), 'icon' => $pIcon),
						array('label'=>$fLabel, 'url'=> array($fAction, 'type' => $type->id, 'id' => $item->id), 'icon' => $fIcon),
						'---',
						array('label'=>'Delete', 'url'=>array('items/delete', 'type' => $type->id, 'id' => $item->id), 'type' => 'danger', 'icon' => 'trash', 'linkOptions' => array('confirm' => 'Are you sure you want to delete '.$item->title.'?')),

					)
				),
			),
		)); 
	?>
</div>