<?php

	/**
	 * Class ModelDataParser
	 */
	class ModelDataParser
	{

		/**
		 * Convierte la data de un modelo dentro de un array a un array clave valor compatible con listas CHtml
		 *
		 * @param $modelData
		 * @param $fields array[]
		 * @param $addAllOption string
		 * @return array
		 */
		public static function toDataList($modelData, $fields, $addAllOption = NULL)
		{
			if (!isset($modelData))
				return NULL;

			$parsedData = array();

			if (is_array($addAllOption) && isset($addAllOption['prepend']))
				$parsedData[-1] = Yii::t('app',$addAllOption['prepend']);

			elseif ($addAllOption === 'prepend')
			{
				$parsedData[-1] = Yii::t('app', 'All');
			}

			foreach ($modelData as $data)
			{
				$string = "";

				foreach ($fields as $key => $field)
				{
					if ($key > 0)
						$string .= ' - ';

					$string .= $data->{$field};
				}

				$parsedData[$data->id] = $string;

			}

			if (is_array($addAllOption) && isset($addAllOption['append']))
				$parsedData[-1] = Yii::t('app',$addAllOption['append']);

			elseif ($addAllOption === 'append')
			{
				$parsedData[-1] = Yii::t('app', 'All');
			}

			return $parsedData;

		}

		/**
		 * retorna el los valores de los atributos de un modelo en formato JSON
		 *
		 * @param $modelData CActiveRecord[]
		 * @param $fields array
		 * @return string
		 */
		public static function toJSONDataList($modelData, $fields)
		{

			$JSON = "";
			$modelsCount = count($modelData);
			$fieldsCount = count($fields);

			foreach ($modelData as $mkey => $model)
			{
				$JSON .= "{";
				$i = 0;

				foreach ($fields as $fkey => $field)
				{
					$JSON .= $fkey . ": '" . $model->{$field} . "'";
					$JSON .= $i < ($fieldsCount - 1) ? "," : '';
					$i++;
				}

				$JSON .= $mkey < ($modelsCount - 1) ? "}," : "}";

			}

			return json_encode($JSON);

		}

	}