<?php

namespace JD\DingoApi\Providers\Auth;

use RainLab\User\Classes\AuthManager;
use Illuminate\Foundation\Application;
use Tymon\JWTAuth\Providers\Auth\IlluminateAuthAdapter as IlluminateAuthAdapterBase;

class IlluminateAuthAdapter extends IlluminateAuthAdapterBase {

    public function __construct(Application $app)
    {
    	$this->auth = $app['jd.dingoapi.auth'];
    }

    public function once(array $credentials)
    {
    	return parent::findUserByCredentials($credentials);
    }
}