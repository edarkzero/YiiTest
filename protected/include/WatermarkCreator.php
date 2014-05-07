<?php
class WatermarkCreator
{
    public static function translucentWatermark($originalImage, $watermark, $saveFile = null, $outputFileTipe = 'jpg')
    {
        $tempFolder = "temp/";
        //$fileRandomValue = 0;
        $cache = $tempFolder . $saveFile . '.' . $outputFileTipe;

        // Load the stamp and the photo to apply the watermark to

        if (strstr($originalImage, '.jpg') !== false)
            $im = imagecreatefromjpeg($originalImage);

        elseif (strstr($originalImage, '.png') !== false)
            $im = imagecreatefrompng($originalImage);

        // First we create our stamp image manually from GD
        $stamp = imagecreatetruecolor(100, 70);
        imagefilledrectangle($stamp, 0, 0, 99, 69, 0x0000FF);
        imagefilledrectangle($stamp, 9, 9, 90, 60, 0xFFFFFF);
        //$im = imagecreatefromjpeg('photo.jpeg');
        imagestring($stamp, 5, 20, 20, 'libGD', 0x0000FF);
        imagestring($stamp, 3, 20, 40, '(c) 2007-9', 0x0000FF);

        // Set the margins for the stamp and get the height/width of the stamp image
        $marge_right = 10;
        $marge_bottom = 10;
        $sx = imagesx($stamp);
        $sy = imagesy($stamp);

        // Merge the stamp onto our photo with an opacity of 50%
        imagecopymerge($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp), 50);

        // Save the image to file and free memory
        imagepng($im, $cache);
        imagedestroy($im);
    }

    public static function simpleWaterMark($originalImage, $watermarkImage, $saveFile = null, $outputFileTipe = 'jpg')
    {
        $tempFolder = "temp/";
        //$fileRandomValue = 0;
        $cache = $tempFolder . $saveFile . '.' . $outputFileTipe;

        // Load the stamp and the photo to apply the watermark to
        $stamp = imagecreatefrompng($watermarkImage);

        if (strstr($originalImage, '.jpg') !== false)
            $im = imagecreatefromjpeg($originalImage);

        elseif (strstr($originalImage, '.png') !== false)
            $im = imagecreatefrompng($originalImage);

        // Set the margins for the stamp and get the height/width of the stamp image
        $marge_right = 10;
        $marge_bottom = 10;
        $sx = imagesx($stamp);
        $sy = imagesy($stamp);

        // Copy the stamp image onto our photo using the margin offsets and the photo
        // width to calculate positioning of the stamp.
        imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

        // Output and free memory

        /*while(file_exists($cache))
        {
            $fileRandomValue = rand(0,getrandmax());
            $saveFile = $saveFile.$fileRandomValue;
            $cache = $tempFolder.$saveFile.'.'.$outputFileTipe;
        }*/

        if ($outputFileTipe == 'jpg')
            imagejpeg($im, $cache);

        elseif ($outputFileTipe == 'png')
            imagepng($im, $cache);

        imagedestroy($im);

        return $cache;

        /*$fp = fopen($cache, 'rb'); # stream the image directly from the cachefile
        fpassthru($fp);*/
    }
}