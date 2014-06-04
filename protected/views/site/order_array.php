<?php
/**
 * @var $data array
 * @var $dataSorted array
 * @var $dataSortedInv array
 */
?>

<p><?php echo Yii::t('app','Function to sort arrays, using binary sort.'); ?></p>

<div class="well">
	<p><?php echo Yii::t('app','Before order'); ?></p>
	<?php DataShow::WALK_ARRAY($data); ?>
</div>

<div class="well">
	<p><?php echo Yii::t('app','After order'); ?></p>
	<?php DataShow::WALK_ARRAY($dataSorted); ?>
</div>

<div class="well">
	<p><?php echo Yii::t('app','After order inverted'); ?></p>
	<?php DataShow::WALK_ARRAY($dataSortedInv); ?>
</div>