<?php

	/*
	 * File: SimpleImage.php
	 * Author: Simon Jarvis
	 * Copyright: 2006 Simon Jarvis
	 * Date: 08/11/06
	 * Link: http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php
	 *
	 * This program is free software; you can redistribute it and/or
	 * modify it under the terms of the GNU General Public License
	 * as published by the Free Software Foundation; either version 2
	 * of the License, or (at your option) any later version.
	 *
	 * This program is distributed in the hope that it will be useful,
	 * but WITHOUT ANY WARRANTY; without even the implied warranty of
	 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	 * GNU General Public License for more details:
	 * http://www.gnu.org/licenses/gpl.html
	 *
	 */

	class SimpleImage
	{

		var $image;
		var $image_type;

		const PATH = '/images/';
		const WIDTH = 200;
		const HEIGHT = 200;

		function load($filename)
		{

			$image_info = getimagesize($filename);
			$this->image_type = $image_info[2];
			if ($this->image_type == IMAGETYPE_JPEG)
			{
				$this->image = imagecreatefromjpeg($filename);
			}
			elseif ($this->image_type == IMAGETYPE_GIF)
			{
				$this->image = imagecreatefromgif($filename);
			}
			elseif ($this->image_type == IMAGETYPE_PNG)
			{

				$this->image = imagecreatefrompng($filename);
			}
		}

		function save($filename, $image_type = IMAGETYPE_JPEG, $compression = 75, $permissions = NULL)
		{

			if ($image_type == IMAGETYPE_JPEG)
			{
				imagejpeg($this->image, $filename, $compression);
			}
			elseif ($image_type == IMAGETYPE_GIF)
			{

				imagegif($this->image, $filename);
			}
			elseif ($image_type == IMAGETYPE_PNG)
			{
				// need this for transparent png to work
				imagealphablending($this->image, false);
				imagesavealpha($this->image, true);
				//End transparent
				imagepng($this->image, $filename);
			}
			if ($permissions != NULL)
			{

				chmod($filename, $permissions);
			}
			
		}

		function output($image_type = IMAGETYPE_JPEG)
		{

			if ($image_type == IMAGETYPE_JPEG)
			{
				imagejpeg($this->image);
			}
			elseif ($image_type == IMAGETYPE_GIF)
			{

				imagegif($this->image);
			}
			elseif ($image_type == IMAGETYPE_PNG)
			{

				imagepng($this->image);
			}
		}

		function getWidth()
		{

			return imagesx($this->image);
		}

		function getHeight()
		{

			return imagesy($this->image);
		}

		function resizeToHeight($height, $force = false)
		{
			if ($height < $this->getHeight() || $force)
			{
				$ratio = $height / $this->getHeight();
				$width = $this->getWidth() * $ratio;
				$this->resize($width, $height);
			}
		}

		function resizeToWidth($width, $force = false)
		{
			if ($width < $this->getWidth() || $force)
			{
				$ratio = $width / $this->getWidth();
				$height = $this->getheight() * $ratio;
				$this->resize($width, $height);
			}
		}

		function scale($scale)
		{
			$width = $this->getWidth() * $scale / 100;
			$height = $this->getheight() * $scale / 100;
			$this->resize($width, $height);
		}

		function resize($width, $height)
		{
			$new_image = imagecreatetruecolor($width, $height);

			/* Check if this image is PNG or GIF, then set if Transparent*/
			if (($this->image_type == IMAGETYPE_GIF) || ($this->image_type == IMAGETYPE_PNG))
			{
				imagealphablending($new_image, false);
				imagesavealpha($new_image, true);
				$transparent = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
				imagefilledrectangle($new_image, 0, 0, $width, $height, $transparent);
			}
			/*End Check image*/

			imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
			$this->image = $new_image;
		}

		function save_imageCURL($img, $fullpath)
		{
			$ch = curl_init($img);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
			$code = curl_getinfo($rch, CURLINFO_HTTP_CODE);
			$rawdata = curl_exec($ch);
			curl_close($ch);
			if (file_exists($fullpath))
			{
				unlink($fullpath);
			}
			$fp = fopen($fullpath, 'x');
			fwrite($fp, $rawdata);
			fclose($fp);
		}

		public function checkURL($url)
		{
			$status = false;
			$rch = curl_init($url);
			$timeOut = 5;
			curl_setopt($rch, CURLOPT_HEADER, false);
			curl_setopt($rch, CURLOPT_RETURNTRANSFER, 1);
			//curl_setopt($ch, CURLOPT_NOBODY, true);
			curl_setopt($rch, CURLOPT_CONNECTTIMEOUT, $timeOut);

			$result = curl_exec($rch);
			$http_status = curl_getinfo($rch, CURLINFO_HTTP_CODE);
			curl_close($rch);

			if ($http_status == 200 || $http_status == 304 || $http_status == 302)
				$status = true;

			return $status;
		}

		/**
		 * Permite guardar las imagenes via UploadedFile.
		 * @param $width ancho de la imagen.
		 * @param $height alto de la imagen.
		 * @param $path ruta de la imagen.
		 * @param $name nombre que se recibira por $_GET, por defecto es images
		 * @return nombre de la imagen.
		 * @throws CHttpException Error 500 si no se pudo guardar la imagen
		 */
		public function saveByUploadedFile($width = SimpleImage::WIDTH, $height = SimpleImage::HEIGHT, $path = SimpleImage::PATH, $name = 'images', $type = IMAGETYPE_JPEG, $proportion = false, $centerCrop = false, $forceResize = false)
		{
			$this->validateImageFolder($path);
			$images = CUploadedFile::getInstancesByName($name);
			$array_images = array();
			if (isset($images) && count($images) > 0)
			{
				foreach ($images as $imagen)
				{
					$fileName = SecurityManager::generateHash() . '.jpg';

					if ($imagen->saveAs($path[0] == '/' ? substr($path, 1) . $fileName : $path . $fileName, false))
					{
						$this->load(Yii::getPathOfAlias('webroot') . $path . $fileName);

						if($this->getWidth() < $width || $this->getHeight() < $height || $this->getHeight() > $this->getWidth())
						{
							Yii::app()->session['imageError'] = 1;
						}
						else Yii::app()->session['imageError'] = 0;

						if($proportion)
						{
							if(!$forceResize)
							{
								$this->resizeToHeight($height);
								$this->resizeToWidth($width);
							}
							else
							{
								if($centerCrop)
								{
									if($this->getHeight() > $this->getWidth())
									{
										$this->resizeToWidth($width, true);
									}
									else
									{
										if($this->getWidth() / $this->getHeight() > 2)  // evitar franjas negras
										{
											$this->resizeToHeight($height, true);
										}
										else
										{
											$this->resizeToHeight($height, true);
											$this->resizeToWidth($width, true);
										}
									}
								}

								else
								{
									$this->resizeToWidth($width, true);
									$this->resizeToHeight($height, true);
								}
							}
						}
						else $this->resize($width, $height);

						if($centerCrop)
						{
							$new_image = imagecreatetruecolor($width, $height);

							imagecopyresampled($new_image, $this->image, 0, 0, ($this->getWidth() - $width) /2, ($this->getHeight() - $height) /2, $width, $height, $width, $height);

							$this->image = $new_image;
						}

						$this->save(Yii::getPathOfAlias('webroot') . $path . $fileName, $type);
						array_push($array_images, $fileName);
					}
					else
					{
						if (file_exists(Yii::getPathOfAlias('webroot') . $path . $fileName))
							unlink(Yii::getPathOfAlias('webroot') . $path . $fileName);
						throw new CHttpException(500, 'No se puede guardar la imagen' . Yii::getPathOfAlias('webroot') . $path . $fileName);
					}
				}
			}

			return $array_images;
		}


		/**
		 * Verifica si existe la carpeta para almacenar la imagen, en caso de que no exista se crea
		 * y se añaden los permisos de lectura y escritura.
		 */
		private function validateImageFolder($path)
		{
			if (!is_dir(Yii::getPathOfAlias('webroot') . $path))
			{
				mkdir(Yii::getPathOfAlias('webroot') . $path);
				chmod(Yii::getPathOfAlias('webroot') . $path, 0777);
			}
		}

		/*
		 * Realiza un crop a una imagen y la guarda
		 * @param $width ancho de la imagen nueva.
		 * @param $height alto de la imagen nueva.
		 * @param $path ruta de la imagen original.
		 * @param $filename nombre de la imagen original.
		 * @param $type tipo de imagen nueva.
		 * @param $x1 Coordenada X del punto superior izquierdo de la selección para crop.
		 * @param $y1 Coordenada Y del punto superior izquierdo de la selección para crop.
		 * @param $selection_width ancho de la selección para crop.
		 * @param $selection_height alto de la selección para crop.
		 * @param $original_width ancho de la imagen original en la vista.
		 * @param $original_height alto de la imagen original en la vista.
		 * @return nombre de la imagen.
		 */
		public function cropAndSaveImage($width = SimpleImage::WIDTH, $height = SimpleImage::HEIGHT, $path = SimpleImage::PATH, $filename = 'image',$type = IMAGETYPE_JPEG, $x1 = 0, $y1 = 0, $selection_width = 0, $selection_height = 0, $original_width = 0, $original_height = 0)
		{
			$this->validateImageFolder($path);
			$array_images = array();

			$this->load(Yii::getPathOfAlias('webroot') . $path . $filename);
			$this->resize($original_width, $original_height);

			$new_image = imagecreatetruecolor($width, $height);

			imagecopyresampled($new_image, $this->image, 0, 0, $x1, $y1, $width, $height, $selection_width, $selection_height);

			$this->image = $new_image;

			$newFilename = $fileName = SecurityManager::generateHash() . '.jpg';

			$this->save(Yii::getPathOfAlias('webroot') . $path . $newFilename, $type);

			array_push($array_images, $newFilename);

			return $array_images;
		}
	}

?>