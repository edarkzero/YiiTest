<?php

	class DataParser
	{
		public static function toHtmlSelectOptions($model, $id, $name, $valueAttr, $contenAttr, $multiple = false, $addAllOption = false, $customOptions = NULL)
		{
			$htmlOutput = '<select ';
			if ($multiple)
				$htmlOutput .= 'multiple';
			$htmlOutput .= ' id="' . $id . '" name="' . $name . '">';

			if (isset($model))
			{
				if ($addAllOption)
					$htmlOutput .= '<option value="-1">' . Yii::t('app', 'Select all') . '</option>';

				if (isset($customOptions) && is_array($customOptions))
				{
					foreach ($customOptions as $option)
					{
						$htmlOutput .= '<option value="' . $option['value'] . '">' . $option['text'] . '</option>';
					}
				}

				if (is_array($model))
				{
					foreach ($model as $data)
					{
						$htmlOutput .= '<option value="' . $data->{$valueAttr} . '">' . $data->{$contenAttr} . '</option>';
					}
				}
				else
					$htmlOutput .= '<option value="' . $model->{$valueAttr} . '">' . $model->{$contenAttr} . '</option>';

			}

			else
				$htmlOutput .= '<option>' . Yii::t('app', 'No results found') . '</option>';

			$htmlOutput .= '</select>';

			return $htmlOutput;
		}

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

			if ($addAllOption === 'prepend')
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

			if ($addAllOption === 'append')
			{
				$parsedData[-1] = Yii::t('app', 'All');
			}

			return $parsedData;

		}
	}