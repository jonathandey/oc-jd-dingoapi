<?php

namespace JD\DingoApi\Classes;

use RainLab\User\Classes\AuthManager as AuthManagerBase;

class AuthManager extends AuthManagerBase {

	public function once(array $credentials = [])
	{
		$user = $this->authenticate($credentials, false);

		return $user;
	}

	public function user()
	{
		$user = $this->getUser();

		return $user;
	}

	public function onceUsingId($id)
	{
		$user = $this->findUserById($id);
		$this->login($user, false);

		return $user;
	}

	public function byId($id)
	{
		return $this->findUserById($id);
	}

}