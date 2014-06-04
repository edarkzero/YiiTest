<?php

	/**
	 * Created by PhpStorm.
	 * User: Edgar
	 * Date: 6/4/14
	 * Time: 10:29 AM
	 */
	class CustomUrlRules extends CBaseUrlRule
	{
		public $connectionID = 'db';
		private $languageTrans = array('es' => 'es_ve','en' => 'en_us');
		private $languageTransInv = array('es_ve' => 'es','en_us' => 'en');

		public function createUrl($manager, $route, $params, $ampersand)
		{
			if(stripos($route,'gii') === false && stripos($route,'hybridauth') === false)
			{
				//Si no existe param lang debe crearse un param lang con los datos de session
				if (!isset($params['lang']))
				{
					$stringParams = $this->paramsToUrl($params);
					$params['lang'] = $this->languageTransInv[Yii::app()->session['lang']];
					return $params['lang'] . '/' . $route.$stringParams;
				}

				else
					return $params['lang'] . '/' . $route;
			}

			return false; // this rule does not apply
		}

		public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
		{
			if(stripos($pathInfo,'gii') === false  && stripos($pathInfo,'hybridauth') === false)
			{
				if (preg_match('%^(\w+)(/(\w+))(/(\w+))?$%', $pathInfo, $matches))
				{
					// check $matches[1] and $matches[3] to see
					// if they match a manufacturer and a model in the database
					// If so, set $_GET['manufacturer'] and/or $_GET['model']
					// and return 'car/index'
					//throw new Exception(print_r(array_merge($matches,array('$pathInfo' => $pathInfo,'rawPathInfo' => $rawPathInfo)),true));

					if(isset($this->languageTrans[$matches[1]]))
					{
						$_GET['lang'] = $matches[1];
						return $matches[3].$matches[4];
					}
				}
			}
			return false; // this rule does not apply
		}

		/**
		 * @param $params array
		 * @return string
		 */
		private function paramsToUrl($params)
		{
			$paramsCount = count($params);
			$stringParams = '';
			$i = 0;

			foreach($params as $key => $param)
			{
				$stringParams .= $key . '=' .$param;

				if($i < $paramsCount-1)
					$stringParams .= '&';

				$i++;
			}

			if($paramsCount > 0)
				$stringParams = '?'.$stringParams;

			return $stringParams;
		}
	}