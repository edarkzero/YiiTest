<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1><?php echo Yii::t('app','Welcome to {name}',array('{name}' => '<i>'.CHtml::encode(Yii::app()->name).'</i>')); ?></h1>

<p><?php echo Yii::t('app','Compilation of global functions to make life easier.'); ?></p>