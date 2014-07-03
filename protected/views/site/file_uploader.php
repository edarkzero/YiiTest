<?php
	/**
	 * Jquery File uploader wrapper
	 * User: Edgar
	 * Date: 4/14/14
	 * Time: 9:32 AM
	 *
	 * @var $uploaderConfig array
	 * @var $this SiteController
	 */

	$cs = Yii::app()->getClientScript();

	$cs->registerCssFile(Yii::app()->getBaseUrl(true) . '/css/site/file_uploader.css');
	$cs->registerCssFile(Yii::app()->getBaseUrl(true) . '/css/dropzone/dropzone.css');

	$cs->registerScriptFile(Yii::app()->getBaseUrl(true) . '/scripts/js/dropzone/dropzone.js', CClientScript::POS_END);
	$cs->registerScriptFile(Yii::app()->getBaseUrl(true) . '/scripts/js/site/file_uploader.js', CClientScript::POS_END);
?>

<script>
	var uploaderID = '<?php echo $uploaderConfig['id_js']; ?>';
	var uploaderProgressID = '<?php echo $uploaderConfig['id_js_progress']; ?>';
</script>

<p><?php echo Yii::t('app', 'File uploader using {ext}', array('{ext}' => 'JQuery File Upload API')); ?></p>

<form id="my-awesome-dropzone" action="<?php echo $this->createUrl('upload'); ?>" class="dropzone" enctype="multipart/form-data">
	<div class="fallback"> <!-- this is the fallback if JS isn't working -->
		<input name="file" type="file" multiple />
	</div>
</form>