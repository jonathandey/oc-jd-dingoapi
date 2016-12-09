<?php

// Place this file in your plugin at: author/plugin/http/api/routes.php
// Place this line in your plugins boot method: require realpath(__DIR__ . '/http/api/routes.php');

use RainLab\User\Models\User;

$api = app('api.router');

// API V1
$api->version('v1', function ($api) {

	// Generate an auth token for the user
	$api->post('auth/token', function() {
		// Set credentials. The login field uses your RainLab.User settings.
		$user = new User;
		$credentials = [$user->getLoginName() => Input::get($user->getLoginName()), 'password' => Input::get('password')];
		
		try {
			// attempt to verify the credentials and create a token for the user
			if (! $token = JWTAuth::attempt($credentials)) {
				return response()->json(['error' => 'invalid_credentials'], 401);
			}
		} catch (JWTException $e) {
			// something went wrong whilst attempting to encode the token
			return response()->json(['error' => 'could_not_create_token'], 500);
		}

		// all good so return the token
		return response()->json(compact('token'));
	});

	// Go to /api/user/details?token={token_from_auth/token}
	// Returns user details from auth token
	$api->get('user/details', ['middleware' => ['api.auth'], function() {
		return $user = JWTAuth::parseToken()->toUser();
	}]);
});