<?php
	/**
	 * Google maps wrapper
	 * User: Edgar
	 * Date: 4/14/14
	 * Time: 9:32 AM
	 *
	 * @var $mapOptions array
	 */

	$cad = "191,294,189,299,193,309,193,318,195,324,195,342,196,343,196,346,195,348,198,355,197,367,194,378,198,386,197,389,197,396,197,398,196,408,196,414,196,424,199,435,206,450,208,453,214,457,221,459,226,461,241,462,242,458,241,456,238,455,234,455,233,449,231,446,227,443,223,443,220,445,217,444,215,440,214,439,213,440,210,438,209,434,212,430,212,427,211,426,212,423,212,421,213,408,209,408,210,406,207,402,207,397,206,393,206,387,206,384,207,382,206,379,204,375,205,372,206,371,206,368,205,365,206,364,207,361,206,359,205,356,202,352,202,347,202,337,204,333,206,331,204,328,204,326,203,321,207,318,207,313,204,313,200,308,198,304,198,301,191,294";
	echo $cad;
	$cadComp = gzcompress($cad);
	echo "<br>";
	echo $cadComp;
	$cadUncomp = gzuncompress($cadComp);
	echo "<br>";
	echo $cadUncomp;
?>