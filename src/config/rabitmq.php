<?php
return array(
	'default'=>array(
		'host'=>'192.168.1.85',//主机
		'port'=>'5672',//端口
		'user'=>'bb',//账号
		'password'=>'bb',//密码
		'vhost'=> '/',//虚拟机
		'ssl'=> false,//是否SSL连接
		'insist' => false,//是否长连接
		'login_method' => 'AMQPLAIN',//登录方式
		'login_response' => null,//
		'locale' => 'en_US',//语言
		'connection_timeout' => 3.0,//连接超时
		'read_write_timeout' => 3.0,//读写超时
		'context' => null,//发送内容
		'keepalive' => false,//保存连接
		'heartbeat' => 0//心跳
	)
);