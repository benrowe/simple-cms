<?php

$this->pageTitle = $user->display.' - '.Yii::app()->name;

?>
<h1><?php echo CHtml::encode($user->display); ?></h1>

<?php $this->widget('Content', array('item' => $user, 'content' => 'bio', 'markdown' => true));