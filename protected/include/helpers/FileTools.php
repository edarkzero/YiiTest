<?php

class FileTools
{
    public static function fileExist($filename)
    {
        $filename = Yii::app()->params['cdn'] . $filename;

        return file_exists($filename);
    }
}