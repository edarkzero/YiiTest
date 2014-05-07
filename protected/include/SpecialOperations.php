<?php

/**
 * Class SpecialOperations
 */
class SpecialOperations
{

    /**
     * @param $string
     * @return mixed
     */
    public static function CLEAR_SPECIAL_CHARACTERS($string)
    {
        $s = mb_strtolower($string, 'UTF-8');

        $s = preg_replace("[áàâãªä@]", "a", $s);
        $s = preg_replace("[ÁÀÂÃÄ]", "A", $s);
        $s = preg_replace("[éèêë]", "e", $s);
        $s = preg_replace("[ÉÈÊË]", "E", $s);
        $s = preg_replace("[íìîï]", "i", $s);
        $s = preg_replace("[ÍÌÎÏ]", "I", $s);
        $s = preg_replace("[óòôõºö]", "o", $s);
        $s = preg_replace("[ÓÒÔÕÖ]", "O", $s);
        $s = preg_replace("[úùûü]", "u", $s);
        $s = preg_replace("[ÚÙÛÜ]", "U", $s);
        $s = str_replace("[¿ ? \]", "_", $s);
        $s = str_replace(" ", "", $s);
        $s = str_replace("ñ", "n", $s);
        $s = str_replace("Ñ", "N", $s);

        return $s;
    }

    /**
     * @param string $datetime
     * @param string $format
     * @param bool $capitalize
     * @return string
     */
    public static function DATETIME_FORMAT($datetime, $format = "y MM dd", $capitalize = true)
    {
        //Esta pregunta es por compatibilidad con base de datos anterior
        if($format === 'd-m-Y' || $format === 'm-d-Y')
        {
            $date = new DateTime($datetime);
            return $date->format($format);
        }

        return $capitalize ? ucfirst(Yii::app()->dateFormatter->format($format,$datetime)) : Yii::app()->dateFormatter->format($format,$datetime);
    }

    public static function ORDER_ARRAY($array,$field,$invert = false)
    {
	    if(!isset($array)) return $array;

	    Yii::app()->session['order_array_field'] = $field;

        function compareNormal($a,$b)
        {
            $aa = $a[Yii::app()->session['order_array_field']];
            $bb = $b[Yii::app()->session['order_array_field']];

            if ($aa == $bb) {
                return 0;
            }

            return ($aa < $bb) ? -1 : 1;

        }

        function compareInverted($a,$b)
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

    /**
     * Agrega ceros a los decimales de un numero redondeado (ej. 2 -> 2.00)
     *
     * @param float|string $number
     * @return string
     */
    public static function ADD_ZEROS_TO_ROUNDED_FLOAT($number)
    {
        if(!is_float($number)) $number = (float)$number;

	    $number = round($number,2);

        $decimals = $number - floor($number);
        if($decimals == .00)
            return $number.'.00';

        return $number;
    }

    /**
     *
     * @param float|string $total
     * @param float|sttring $percent
     * @param bool $added Added true si quieres que se le sume al porcentaje agregado el total, false si solo se quiere el porcentaje
     * @param bool $forceFloat true si se quiere los .00 en un numero que resulte entero
     * @return float
     */
    public static function GET_PERCENT_ADDED($total,$percent,$added = false,$forceFloat = false)
    {
        if(!is_float($total)) $total = (float)$total;
        if(!is_float($percent)) $percent = (float)$percent;

	    $result = $total*($percent/100);

        if($added)
		    $result += $total;

	    if(!$forceFloat) return $result;
	    else return self::ADD_ZEROS_TO_ROUNDED_FLOAT($result);
    }

}