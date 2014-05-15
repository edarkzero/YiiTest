<?php

	class WatermarkCreator
	{
		const FONT_PIXEL = 2.5;

		public static function translucentStringWatermark($originalImage, $watermark, $saveFile = 'noname', $outputFileTipe = 'jpg')
		{
			$tempFolder = "temp/";
			//$fileRandomValue = 0;
			$cache = $tempFolder . $saveFile . '.' . $outputFileTipe;

			// Load the stamp and the photo to apply the watermark to

			if (strstr($originalImage, '.jpg') !== false || strstr($originalImage, '.jpg') !== false)
				$im = imagecreatefromjpeg($originalImage);

			elseif (strstr($originalImage, '.png') !== false)
				$im = imagecreatefrompng($originalImage);

			//Get the length of the string watermark and his font size
			$stampFontSize = 3;
			$stampWidth = strlen($watermark) * $stampFontSize * self::FONT_PIXEL;

			// First we create our stamp image manually from GD
			$stamp = imagecreatetruecolor($stampWidth, 25);
			/*imagefilledrectangle($stamp, 0, 0, 99, 69, 0x0000FF);
			imagefilledrectangle($stamp, 9, 9, 90, 60, 0xFFFFFF);*/
			//$im = imagecreatefromjpeg('photo.jpeg');
			imagestring($stamp, $stampFontSize, 10, 5, $watermark, 0xFFFFFF);
			//imagestring($stamp, 3, 20, 40, '(c) 2007-9', 0x0000FF);

			// Set the margins for the stamp and get the height/width of the stamp image
			$marge_right = 10;
			$marge_bottom = 10;
			$sx = imagesx($stamp);
			$sy = imagesy($stamp);

			// Merge the stamp onto our photo with an opacity of 50%
			imagecopymerge($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp), 50);

			// Save the image to file and free memory
			if (strstr($originalImage, '.jpg') !== false)
				imagejpeg($im, $cache, 100);

			elseif (strstr($originalImage, '.png') !== false)
				imagepng($im, $cache, 100);

			imagedestroy($im);

			return $cache;
		}

		public static function simpleImageWatermark($originalImage, $watermarkImage, $saveFile = NULL, $outputFileTipe = 'jpg')
		{
			$tempFolder = "temp/";
			//$fileRandomValue = 0;
			$cache = $tempFolder . $saveFile . '.' . $outputFileTipe;

			if (strstr($originalImage, '.jpg') !== false)
				$im = imagecreatefromjpeg($originalImage);

			elseif (strstr($originalImage, '.png') !== false)
				$im = imagecreatefrompng($originalImage);

			if (strstr($originalImage, '.jpg') !== false)
				$stamp = imagecreatefromjpeg($watermarkImage);

			elseif (strstr($originalImage, '.png') !== false)
				$stamp = imagecreatefrompng($watermarkImage);

			// Set the margins for the stamp and get the height/width of the stamp image
			$marge_right = 10;
			$marge_bottom = 10;
			$sx = imagesx($stamp);
			$sy = imagesy($stamp);

			// Copy the stamp image onto our photo using the margin offsets and the photo
			// width to calculate positioning of the stamp.
			//imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
			imagecopymerge($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp), 50);

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