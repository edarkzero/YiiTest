<?php
/**
 * Created by PhpStorm.
 * User: Edgar
 * Date: 8/19/14
 * Time: 12:01 PM
 */
?>

<div>
	<p><?php echo Yii::t('app','User IP'); ?></p>
	<pre><?php echo IpTools::GET_USER_IP(); ?></pre>
	<p><?php echo Yii::t('app','Format IP to database') ?></p>
	<pre><?php echo IpTools::GET_USER_IP().' -> '.IpTools::GET_USER_IP_BDD_FORMAT(); ?></pre>
	<p><?php echo Yii::t('app','Get the IP information') ?></p>
	<pre><?php print_r(IpTools::GET_IP_DATA_EXTERNAL_SOURCE(false)); ?></pre>
</div>