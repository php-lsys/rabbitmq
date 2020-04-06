<?php
return array(
	'default'=>array(
		'host'=>'192.168.1.85',
		'port'=>'5672',
		'user'=>'bb',
		'password'=>'bb',
		'vhost'=> '/',
		'insist' => NULL,//client is false ,server is true
		'login_method' => 'AMQPLAIN',
		'login_response' => null,
		'locale' => 'en_US',
		'connection_timeout' => 3.0,
		'read_write_timeout' => 3.0,
		'context' => null,
		'keepalive' => false,
		'heartbeat' => 0
	)
);