<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<link href="<?php echo Yii::app()->getBaseUrl(true) . '/scripts/jquery-ui/'; ?>css/ui-lightness/jquery-ui-1.10.4.custom.css" rel="stylesheet">
	<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico" type="image/x-icon" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<?php
		//Need to register this two cores in this order
		Yii::app()->clientScript->registerCoreScript('jquery');
		Yii::app()->clientScript->registerCoreScript('jquery.ui');
	?>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div>
	<!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu', array(
			'items' => array(
				array('label' => Yii::t('app','Home'), 'url' => array('/site/index')),
				array('label' => Yii::t('app','Map'), 'url' => array('/site/map')),
				array('label' => Yii::t('app','Social networks'), 'url' => array('/site/social')),
				array('label' => Yii::t('app','Array Order'), 'url' => array('/site/order_array')),
				array('label' => Yii::t('app','File uploader'), 'url' => array('/site/file_uploader')),
				array('label' => Yii::t('app','String compressor'), 'url' => array('/site/string_compressor')),
				array('label' => Yii::t('app','IP tools'), 'url' => array('/site/ip_tools')),
				array('label' => Yii::t('app','Fancybox'), 'url' => array('/site/fancybox')),
				array('label' => Yii::t('app','Taskbar'), 'url' => array('/site/taskbar')),
				array('label' => Yii::t('app','About'), 'url' => array('/site/page', 'view' => 'about','test' => '1011')),
				array('label' => Yii::t('app','Contact'), 'url' => array('/site/contact')),
				array('label' => Yii::t('app','Login'), 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
				array('label' => Yii::t('app','Logout').' (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest),
				array('label' => '|'),
				array('label' => 'Gii', 'url' => array('/gii')),
				array('label' => '|'),
				array('label' => 'En', 'url' => array('','lang' => 'en')),
				array('label' => 'Es', 'url' => array('','lang' => 'es')),
			),
		)); ?>
	</div>

	<!-- mainmenu -->
	<?php if (isset($this->breadcrumbs)): ?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links' => $this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif ?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer"><?php echo Yii::t('app','Copyright {copy} {date} by {name}.{separator}All Rights Reserved.{separator}',array(
			'{copy}' => '&copy;','{date}' => date('Y'),'{separator}' => '<br />','{name}' => 'Edgar Cardona'
		)); ?>
		<?php echo Yii::powered(); ?>
	</div>
	<!-- footer -->

</div>
<!-- page -->

</body>
</html>
