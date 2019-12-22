<?php defined('SYSPATH') OR die('No direct access allowed.');

return array
(
	'driver' => 'ORM',
	'hash_method' => 'sha256',
	'hash_key' => '123598123568612638',
	'lifetime' => 1209600,
    'session_type' => Session::$default,	// native
	'session_key' => 'auth_user',
	'users' => []
);
