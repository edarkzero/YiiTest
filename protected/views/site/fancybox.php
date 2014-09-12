<?php
	$cs = Yii::app()->getClientScript();

	$cs->registerScriptFile(Yii::app()->getBaseUrl(true) . '/scripts/js/site/fancybox.js', CClientScript::POS_END);
	$cs->registerScriptFile(Yii::app()->getBaseUrl(true) . '/scripts/js/fancybox/lib/jquery.mousewheel-3.0.6.pack.js', CClientScript::POS_END);
	$cs->registerScriptFile(Yii::app()->getBaseUrl(true) . '/scripts/js/fancybox/source/jquery.fancybox.pack.js?v=2.1.5', CClientScript::POS_END);

	$cs->registerCssFile(Yii::app()->getBaseUrl(true) . '/scripts/js/fancybox/source/jquery.fancybox.css?v=2.1.5', 'screen');
?>

<a class="fancybox" rel="group" href="<?php echo Yii::app()->getBaseUrl(true).'/images/site/marker1.png'; ?>"><img src="<?php echo Yii::app()->getBaseUrl(true).'/images/site/marker1.png'; ?>" alt="" /></a>
<a class="fancybox" rel="group" href="<?php echo Yii::app()->getBaseUrl(true).'/images/site/marker2.png'; ?>"><img src="<?php echo Yii::app()->getBaseUrl(true).'/images/site/marker2.png'; ?>" alt="" /></a>