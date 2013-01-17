<!DOCTYPE HTML>

<html lang="en-US">
<head>
	<meta charset="UTF-8">

	<!--<link href='http://fonts.googleapis.com/css?family=Ledger' rel='stylesheet' type='text/css'>-->
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<!-- blueprint CSS framework -->
	<!--<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />-->
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<!--<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />-->

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
		<div id="sub-logo">Programmer</div>
	</div><!-- header -->
	<div class="nav nav-top">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'Articles', 'url'=>array('/site/type', 'type'=>'article')),
				array('label'=>'Portfolio', 'url'=>array('/site/type', 'type'=>'portfolio')),
				array('label'=>'Gallery', 'url'=>array('/site/type', 'type'=>'gallery')),
				array('label'=>'Project', 'url'=>array('/site/type', 'type'=>'project')),
				array('label'=>'About Me', 'url'=>array('/site/item', 'slug'=>'about-me')),
				//array('label'=>'Contact', 'url'=>array('/site/contact')),
				//array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				//array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
			'separator' => ' &mdash; '
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="nav nav-bottom">
	<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'Articles', 'url'=>array('/site/type', 'type'=>'article')),
				array('label'=>'Portfolio', 'url'=>array('/site/type', 'type'=>'portfolio')),
				array('label'=>'Gallery', 'url'=>array('/site/type', 'type'=>'gallery')),
				array('label'=>'Project', 'url'=>array('/site/type', 'type'=>'project')),
				array('label'=>'About Me', 'url'=>array('/site/item', 'slug'=>'about-me')),
				//array('label'=>'Contact', 'url'=>array('/site/contact')),
				//array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				//array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div>
	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by Ben Rowe<br/>
		All Rights Reserved.<br/>
	</div><!-- footer -->

</div><!-- page -->
<?php if(Config::instance()->gaEnabled): ?>
	<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?php echo Config::instance()->gaTrackingNumber; ?>']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<?php endif; ?>
</body>
</html>