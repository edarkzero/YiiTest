<?php
/**
 * Created by JetBrains PhpStorm.
 * User: edark_000
 * Date: 04/10/13
 * Time: 03:06 PM
 * To change this template use File | Settings | File Templates.
 */

class SessionManager
{
    const TESTING_USER = 51;
	const CLIENTE_USER = 'cliente';
	const PERSONAL_USER = 'personal';
	const VISITANTE_USER = 'visitante';

	/**
	 * @param $name
	 * @param bool $destroy
	 * @param bool $throwException
	 * @return mixed
	 * @throws CHttpException
	 */
	public static function  GET_SESSION($name,$destroy = false, $throwException = false)
    {
        if (!isset(Yii::app()->session[$name])) {
            //TODO: cambiar esto por un render para mostrar un error amigable sin detalles de codigo php.
            if ($throwException)
                throw new CHttpException(403, Yii::t('app', 'The specified request cannot be found') . '.');

            return -1;
        }

	    else
	    {
		    $var = Yii::app()->session[$name];

		    if($destroy)
			    Yii::app()->session[$name] = null;

		    return $var;
	    }
    }

    public static function  SET_SESSION($name, $value)
    {
        Yii::app()->session[$name] = $value;
    }

	public static function getSessionKeys()
	{
		DataShow::WALK_ARRAY(Yii::app()->session->keys);
	}

	public static function unset_session($name)
	{
		unset(Yii::app()->session[$name]);
	}

    public static function GET_USER($attribute = null)
    {
        if($attribute != null)
            return isset(Yii::app()->user->{$attribute}) ? Yii::app()->user->{$attribute} : null;
        else
            return Validator::HAS_DATA(Yii::app()->user) ? Yii::app()->user : null;
    }

    /**
     * Retorna el rol de usuario
     * @return rol de la cuenta de usuario
     */
    public static function getRole()
    {
        return isset(Yii::app()->user->rol) ? Yii::app()->user->rol : -1;
    }

	public static function getFranquiciaProducto()
	{
		return Yii::app()->session['franquiciaProducto'];
	}

	public static function getCountry()
	{
		return SessionManager::GET_SESSION('country');
	}

	public static function getUserID()
	{
		return self::GET_USER('id');
	}

	public static function getUserCuenta()
	{
		if(self::isUserVisitante())
			return self::GET_USER('idVisitanteCuentas');
		else
			return self::GET_USER('idCuenta');
	}

    public static function GET_TIPO_MONEDA()
    {
        return Yii::app()->session['countryMoneda'];
    }

	public static function isUserCliente()
	{
		return !Yii::app()->user->isGuest && self::GET_USER('rol') == TipoRoles::CLIENTE;
	}

	public static function isUserVisitante()
	{
		return !Yii::app()->user->isGuest && self::GET_USER('rol') == TipoRoles::VISITANTE;
	}

	public static function isUserPersonal()
	{
		return !self::isUserCliente() && !self::isUserPersonal();
	}

	public static function isUserRedSocial()
	{
		return !self::isUserOnbizzRegistered();
	}

	public static function isUserOnbizzRegistered()
	{
		return (!Yii::app()->user->isGuest && SessionManager::GET_USER('rol') != null);
	}

	public static function isUserQponeraRegistered()
	{
		return self::isUserVisitante() || self::isUserRedSocial();
	}

	public static function getNombreUsuario()
	{
		$logged = !Yii::app()->user->isGuest;

		if($logged)
		{
			if(SessionManager::GET_USER('fullname') !== null)
				return SessionManager::GET_USER('fullname');
			elseif(SessionManager::GET_USER('nombre') !== null)
				return SessionManager::GET_USER('nombre');
			elseif(SessionManager::GET_USER('username')  !== null)
				return SessionManager::GET_USER('username');
		}

		return '';
	}

	public static function getDateFormat()
	{
		return Yii::app()->session['countryFormatoFecha'];
	}

	public static function getDateFormatJs()
	{
		return Yii::app()->session['countryFormatoFechaJS'];
	}

	public static function getLastUrl()
	{
		return Yii::app()->session['lastUrl'];
	}

}