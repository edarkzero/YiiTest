<?php
class DateTools
{
    const BDD_DATE_FORMAT = 'Y-m-d';

    static function CUSTOM_MAKE_DATE_TIME($values = null, $format = null)
    {
        //TODO: INCOMPLETE METHOD

        if(isset($values))
        {
            if($format == null) $format = self::BDD_DATE_FORMAT;

            $year = date("Y");
            $month = 'date("m")';
            $day = date("d");
            $hour = 0;
            $min = 0;
            $sec = 0;

            if(isset($values['month']))
            {
                $str = $month.$values["month"];
                $month = eval('return $str');
                echo $month;
            }

            return date($format,mktime($hour, $min, $sec, $month, $day,   $year));
        }

        return null;
    }
}