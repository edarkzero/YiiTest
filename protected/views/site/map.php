<?php
	/**
	 * Google maps wrapper
	 * User: Edgar
	 * Date: 4/14/14
	 * Time: 9:32 AM
	 *
	 * @var $mapOptions array
	 */

	$cs = Yii::app()->getClientScript();
	$cs->registerScriptFile(Yii::app()->getBaseUrl(true) . '/scripts/js/site/map.js', CClientScript::POS_END);
	$cs->registerScriptFile("https://maps.googleapis.com/maps/api/js?key=AIzaSyBlUd3oWqgl00-XFF1uO1fdsaaZzJ-y5Gg&sensor=false", CClientScript::POS_END);
?>

<script>
	var markersData = <?php echo isset($mapOptions['markersData']) ? $mapOptions['markersData'] : "null"; ?>;
	var addMarkers = <?php echo isset($mapOptions['addMarkers']) ? $mapOptions['addMarkers'] : "null"; ?>;
	var defaultUI = <?php echo isset($mapOptions['defaultUI']) ? $mapOptions['defaultUI'] : "null"; ?>;
</script>

<div id="<?php if(isset($mapOptions['id'])) echo $mapOptions['id']; ?>" style="width: 600px; height: 480px; margin: 20px auto"></div>