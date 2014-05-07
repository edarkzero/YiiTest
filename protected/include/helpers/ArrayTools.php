<?php

class ArrayTools
{
    public static function ORDER_ARRAY($array, $field, $invert = false)
    {
        if (!isset($array)) return $array;
        if(count($array) == 1) return $array;

        Yii::app()->session['order_array_field'] = $field;

        function compareNormal($a, $b)
        {
            $aa = $a[Yii::app()->session['order_array_field']];
            $bb = $b[Yii::app()->session['order_array_field']];

            if ($aa == $bb) {
                return 0;
            }

            return ($aa < $bb) ? -1 : 1;

        }

        function compareInverted($a, $b)
        {
            $aa = $a[Yii::app()->session['order_array_field']];
            $bb = $b[Yii::app()->session['order_array_field']];

            if ($aa == $bb) {
                return 0;
            }

            return ($aa < $bb) ? 1 : -1;

        }

        $invert ? usort($array, "compareNormal") : usort($array, "compareInverted");
        unset(Yii::app()->session['order_array_field']);
        return $array;

    }
}