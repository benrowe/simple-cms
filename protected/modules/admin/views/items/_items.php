<div class="items">
<?php foreach($items as $item): ?>
    <?php $this->renderPartial('_item', array('item' => $item, 'type' => $type)); ?>
<?php endforeach; ?>
</div>