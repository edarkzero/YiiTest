<?php
$cs = Yii::app()->getClientScript();
$cs->registerCssFile(Yii::app()->getBaseUrl(true) . '/css/site/taskbar.css');
?>

<div id="taskbar">
    <div id="taskbar-content">
        <?php for ($i = 1; $i <= 8; $i++): ?>
            <div class="taskbar-icon float-left">
                <a class="taskbar-link" href="#"><?php echo Yii::t('app', 'Test {n}', array('{n}' => $i)); ?></a>
            </div>
        <?php endfor; ?>
        <div class="clear"></div>
    </div>
</div>