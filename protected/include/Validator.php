<?php
/**
 * Created by JetBrains PhpStorm.
 * User: edark_000
 * Date: 04/10/13
 * Time: 03:22 PM
 * To change this template use File | Settings | File Templates.
 */

class Validator 
{
    /**
     * @param $data
     * @param bool $throwException
     * @return bool
     * @throws CHttpException
     */
    public static function HAS_DATA($data, $throwException = false)
    {
        $success = isset($data) && !empty($data) ? true : false;
        if(is_array($data)) $success = count($data) > 0 ? true : false;
        elseif(is_string($data)) $success = $data != "" ? true : false;

        if ($throwException)
        {
            if($success)
                return $success;

            else
                throw new CHttpException(403, Yii::t('app', 'The specified request cannot be found') . '.');
        }

        else
            return $success;

    }
}