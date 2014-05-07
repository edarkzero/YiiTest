<?php
/**
 * Created by JetBrains PhpStorm.
 * User: edark_000
 * Date: 04/10/13
 * Time: 02:19 PM
 * To change this template use File | Settings | File Templates.
 */

class IpTools
{
    /**
     * @return string|null
     */
    public static function GET_USER_IP()
    {
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {$ip=$_SERVER['HTTP_CLIENT_IP'];}
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];}
        else {$ip=$_SERVER['REMOTE_ADDR'];}

        return $ip;
    }

    public static function FORMAT_IP_TO_BDD($ip)
    {
        return sprintf("%u", ip2long($ip));
    }

    public static function GET_USER_IP_BDD_FORMAT()
    {
        return self::FORMAT_IP_TO_BDD(self::GET_USER_IP());
    }

    public static function GET_IP_DATA_EXTERNAL_SOURCE($return_string = true,$cip = null,$attributes = array('country','city'))
    {
        if($cip == null)
        {
            if (isset($_SERVER['HTTP_CLIENT_IP'])) {$real_ip_adress=$_SERVER['HTTP_CLIENT_IP'];}
            else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {$real_ip_adress=$_SERVER['HTTP_X_FORWARDED_FOR'];}
            else {$real_ip_adress=$_SERVER['REMOTE_ADDR'];}
            $cip=$real_ip_adress;
//        $cip="190.198.239.58"; //AIA
//        $cip="177.8.112.0"; //Brasil
            //$cip="156.97.0.0"; //CHile
//        $cip="12.215.42.19"; //Usa
//        $cip="181.144.0.0"; //Colombia
//        $cip="181.233.192.0"; //Peru
//        $cip="179.48.208.0"; //Panama
//        $iptolocation='http://api.hostip.info/?ip='.$cip;
//        $iptolocation='http://api.hostip.info/country.php?ip='.$cip;
            //https://dazzlepod.com/ip/
//            $iptolocation='http://dazzlepod.com/ip/'.$cip.'.json';
//            $iptolocation='http://dazzlepod.com/ip/'.$cip.'.json';
//        $iptolocation='http://api.hostip.info/get_html.php?ip='.$cip.'&position=true';
//        $iptolocation='http://api.hostip.info/get_json.php';
//        $iptolocation='http://api.hostip.info/?ip=$cip';
//        $iptolocation='http://stonito.com/script/geoip/?ip='.$cip;
            $iptolocation = "http://www.geoplugin.net/json.gp?ip=".$cip;
            $creatorlocation=@file_get_contents($iptolocation);

            if($return_string)
            {
                $result = "";
                $creatorlocation = @json_decode($creatorlocation);

                foreach($attributes as $attr)
                {
                    $result .= $creatorlocation->{$attr}.'<br/>';
                }

                return $result;
            }

            else return $creatorlocation = json_decode($creatorlocation,true);

        }

    }

}