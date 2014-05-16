<?php

class ArrayTools
{
	/**
	 * @param array $array
	 * @param string $field
	 * @param bool $invert
	 * @return array
	 */
	public static function ORDER_ARRAY($array, $field, $invert = false)
    {
        if (!isset($array)) return $array;
        if(count($array) == 1) return $array;

        Yii::app()->session['order_array_field'] = $field;
        $invert ? usort($array, array("ArrayTools","compareNormal")) : usort($array, array("ArrayTools","compareInverted"));
        unset(Yii::app()->session['order_array_field']);
        return $array;

    }

	public static function ORDER_ARRAY_COUNT($array, $invert = false)
	{

		function cmp($a,$b)
		{
			$aa = count($a);
			$bb = count($b);

			if ($aa == $bb) {
				return 0;
			}

			return ($aa < $bb) ? -1 : 1;

		}

		function cmpInv($a,$b)
		{
			$aa = count($a);
			$bb = count($b);

			if ($aa == $bb) {
				return 0;
			}

			return ($aa < $bb) ? 1 : -1;

		}

		$invert ? usort($array, "cmp") : usort($array, "cmpInv");
		return $array;

	}

	public static function compareNormal($a, $b)
	{
		$aa = $a[Yii::app()->session['order_array_field']];
		$bb = $b[Yii::app()->session['order_array_field']];

		if ($aa == $bb) {
			return 0;
		}

		return ($aa < $bb) ? -1 : 1;

	}

	public static function compareInverted($a, $b)
	{
		$aa = $a[Yii::app()->session['order_array_field']];
		$bb = $b[Yii::app()->session['order_array_field']];

		if ($aa == $bb) {
			return 0;
		}

		return ($aa < $bb) ? 1 : -1;

	}
}