<?php
	/**
	 * Created by PhpStorm.
	 * User: Edgar
	 * Date: 5/6/14
	 * Time: 3:46 PM
	 */
?>

<div class="zocial-container">
	<div class="zocial-wrapper">
		<a class="zocial google" href="<?php echo $this->createUrl('/hybridauth/login', array('provider' => 'google')); ?>"></a>
		<a class="zocial facebook" href="<?php echo $this->createUrl('/hybridauth/login', array('provider' => 'facebook')); ?>"></a>
	</div>
</div>
<div class="clear"></div>