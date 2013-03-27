<?php 
	/* @var $data User */ 
	$md = new CMarkdown;
?>
<div>
	<h2><?php echo CHtml::link($data->display, array('users/edit', 'id' => $data->id)); ?> (<?php echo CHtml::encode($data->email); ?>)</h2>
	<div class="description">
		<?php echo $md->transform($data->bio); ?>
	</div>
	<?php 
	
		$this->widget('bootstrap.widgets.BootButtonGroup', array(
			//'type'=>'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
			'buttons'=>array(
				array('label'=>'Edit', 'icon' => 'pencil', 'url'=>array('users/edit', 'id' => $data->id)),
				array(
					'items'=>array(
						//'---',
						array('label'=>'Delete', 'url'=>array('users/delete', 'id' => $data->id), 'type' => 'danger', 'icon' => 'trash', 'linkOptions' => array('confirm' => 'Are you sure you want to delete '.$data->display.'?')),

					)
				),
			),
		)); 
	?>
</div>