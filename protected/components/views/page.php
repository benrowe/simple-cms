<h2><?php echo $page->title; ?> (<?php echo $index.' of '.$total; ?>)</h2>
<?php $this->widget('Content', array('item' => $page, 'content' => 'body', 'markdown' => true)); ?>
