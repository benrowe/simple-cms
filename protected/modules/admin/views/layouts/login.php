<?php

/* @var $cs CClientScript */
$cs = Yii::app()->clientScript;
$cs->coreScriptPosition = CClientScript::POS_END;
$cs->registerCoreScript('jquery');

$cs->registerScriptFile(Yii::app()->baseUrl.'/js/common-admin.js', CClientScript::POS_END);
$cs->registerCssFile(Yii::app()->baseUrl.'/css/admin.css');

?>

<!DOCTYPE HTML>

<html lang="en-US">
<head>
	<meta charset="UTF-8">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">
	
	<?php
		if(($flashes = Yii::app()->user->getFlashes()) != false) {
			echo '<div class="alerts">';
			foreach ($flashes as $key => $message) {
				echo '<div class="alert alert-' . $key . '">' . $message . "</div>\n";
			}
			echo '</div>';
		}
	?>
		
	<?php echo $content; ?>

</div><!-- page -->

</body>
</html>