<?php
/**
 * Created by JetBrains PhpStorm.
 * User: edark_000
 * Date: 07/10/13
 * Time: 09:15 AM
 * To change this template use File | Settings | File Templates.
 */

class DataShow 
{
    public static function WALK_ARRAY($array,$return_data = false,$end = false)
    {
        $output = "";

        $output .= "<pre>";

        if(Validator::HAS_DATA($array))
        {
            if(is_array($array))
            {
                foreach($array as $key => $data)
                {
                    if(!is_array($data))
                        $output .= $key . ' => ' .$data. '<br/>';
                    else
                    {
                        $output .= $key.' => '.self::WALK_ARRAY($data,true);
                    }

                }
            }
        }

        $output .= "</pre>";

        if(!$return_data)
            echo $output;

        else
            return $output;

        if($end) Yii::app()->end();

    }

}