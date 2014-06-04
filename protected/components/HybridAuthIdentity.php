<?php

class HybridAuthIdentity extends CUserIdentity
{
    /**
     *
     * @var Hybrid_Auth
     */
    public $hybridAuth;

    /**
     *
     * @var Hybrid_Provider_Adapter
     */
    public $adapter;

    public $email, $create_at, $lastvisit_at;
    /**
     *
     * @var Hybrid_User_Profile
     */
    public $userProfile;

    public $allowedProviders = array('google', 'facebook'/*, 'twitter', 'live', 'yahoo'*/);

    protected $config;

    function __construct()
    {
        $path = Yii::getPathOfAlias('ext.hybridauth');
        require_once $path . '/Hybrid/Auth.php'; //path to the Auth php file within HybridAuth folder

        $this->config = array(
            "base_url"   => Yii::app()->createAbsoluteUrl('/hybridauth/socialLogin'),

            "providers"  => array(
                "Google"   => array(
                    "enabled"     => true,
                    "keys"        => array(
                        //"id"     => "968404240122-ccgaejauo569eoqdquj9trn8fbg244no.apps.googleusercontent.com",
                        //"id"     => "310798286276-qgce9rp9rtqcgkbbdishraht1cgthg4p.apps.googleusercontent.com",
                        "id"     => "423332839918-t6jvp3tcahcift8o5j98nejk9tdbt85o.apps.googleusercontent.com",
                        //"secret" => "hSAWabnS9otVAsxEJw9q18xl",
                        //"secret" => "svcvNJXKbr16qNdxmVJNvugK",
                        "secret" => "c0DDL6u8ewX_A-Yq86l01wAn",
                    ),
                    "scope"       => "https://www.googleapis.com/auth/userinfo.profile " . "https://www.googleapis.com/auth/userinfo.email",
                    "access_type" => "online",
                ),
                "Facebook" => array(
                    "enabled" => true,
                    "keys"    => array(
                        "id"     => "1465996826970478",
                        "secret" => "4e9105f35bef2847afc316db50a95a51",
                    ),
                    "scope"   => "email, publish_stream"
                ),
                "Twitter"  => array( // 'key' is your twitter application consumer key
                    "enabled" => false,
                    "keys"    => array(
                        "key"    => "HJNKTItCYHA31Sy8aPpEA",
                        "secret" => "67hanaGIavFRMzrGlCEE5Ko9hsVqZsCRigLQMnYaZ8"
                    )
                ),
                "Live" => array (
                    "enabled" => false,
                    "keys" => array (
                        "id" => "000000004C11391C",
                        "secret" => "ioN1lzNTP-MllKG8VtkpfyHnOX5afzkj",
                    )
                ),
                "Yahoo" => array(
                    "enabled" => false,
                    "keys" => array (
                        "key" => "dj0yJmk9NjBoV0FaSzNvU1VVJmQ9WVdrOWVXOTJWbFZ0TnpnbWNHbzlNVE01TlRFNE16ZzJNZy0tJnM9Y29uc3VtZXJzZWNyZXQmeD04Mw--",
                        "secret" => "fa33391ff7cd08b6666e0e262f645d236eea3da0",
                    ),
                ),
                /*"LinkedIn" => array(
                    "enabled" => true,
                    "keys" => array (
                        "key" => "linkedin client id",
                        "secret" => "linkedin secret",
                    ),
                ),*/
            ),

            "debug_mode" => false,

            // to enable logging, set 'debug_mode' to true, then provide here a path of a writable file
            "debug_file" => "",
        );

        $this->hybridAuth = new Hybrid_Auth($this->config);
    }

    /**
     *
     * @param string $provider
     * @return bool
     */
    public function validateProviderName($provider)
    {
        if (!is_string($provider))
            return false;
        if (!in_array($provider, $this->allowedProviders))
            return false;

        return true;
    }

    public function login()
    {
        /*$path = Yii::getPathOfAlias('application.modules.backend.models');
        require_once $path . '/SocialNetwork.php'; //path to the Auth php file within HybridAuth folder*/

        $this->username = $this->userProfile->displayName; //CUserIdentity
        $socialNetworkID = $this->adapter->id; //TODO: Revisar un identificador unico de red social

        $model = new Visitantes();

        $findModel = $model->findByAttributes(array('username' => $this->username,'id_producto' => Producto::QPONERA,'loginProvider' => $socialNetworkID, 'loginProviderIdentifier' => $this->userProfile->identifier));

        if(isset($findModel))
        {
            $this->setState('id',$findModel->id);
            $this->setState('username',$findModel->username);
            $this->setState('type',Visitantes::label());

            Yii::app()->user->login($this, 86400);
            return;
        }

	    $model->id_producto = Producto::QPONERA;
        $model->username = $this->username;
        //$model->email = isset($this->userProfile->email) && !empty($this->userProfile->email) ? $this->userProfile->email : $this->username;
        $model->loginProviderIdentifier = $this->userProfile->identifier;
        $model->loginProvider = $socialNetworkID;
	    $model->nombre = $this->userProfile->firstName;
        $model->apellido = $this->userProfile->lastName;
	    //$model->fecha_nacimiento = date()

        if ($model->save(false)) {
            $identity = new UserIdentity($model->username, '');
            //$identity->authenticate();
            $identity->setState('id',$model->id);
            $identity->setState('username',$model->username);
	        $identity->setState('type',Visitantes::label());

            Yii::app()->user->login($identity, 86400);
        }
    }

    public function authenticate()
    {
        return true;
    }

}