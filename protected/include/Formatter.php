<?php

	/**
	 * File: Formatter.php
	 * Author: Pedro Hernández
	 * Date: 27/06/2013
	 *
	 */
	class Formatter
	{
		public static function getPhone($tipo = -1)
		{
			if (SessionManager::GET_SESSION('country')== Pais::PANAMA)
			{
				if ($tipo == TipoTelefonos::CELULAR)
				{
					return '(+999) 6999-9999';
				}
				else
				{
					return '(+999) 999-9999';
				}
			}

			return '(+99) 999-999.99.99';

		}
	}

?>