<?php
	$cs = Yii::app()->getClientScript();
	$cs->registerCssFile(Yii::app()->getBaseUrl(true) . '/css/site/taskbar.css');
?>

<div id="taskbar">
	<div id="taskbar-content">
		<div class="taskbar-icon float-left">
			<a class="taskbar-link" href="#"><?php echo Yii::t('app', 'Test {n}', array('{n}' => 1)); ?></a>
		</div>

		<div class="taskbar-icon float-left">
			<a class="taskbar-link" href="#"><?php echo Yii::t('app', 'Test {n}', array('{n}' => 2)); ?></a>
		</div>

		<div class="taskbar-icon float-left">
			<a class="taskbar-link" href="#"><?php echo Yii::t('app', 'Test {n}', array('{n}' => 3)); ?></a>
		</div>

		<div class="taskbar-icon float-left">
			<a class="taskbar-link" href="#"><?php echo Yii::t('app', 'Test {n}', array('{n}' => 4)); ?></a>
		</div>

		<div class="clear"></div>
	</div>
</div>