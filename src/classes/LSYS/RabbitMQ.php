<?php
/**
 * lsys ribbatmq
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace LSYS;
class RabbitMQ extends \PhpAmqpLib\Connection\AMQPLazyConnection{
	// OK SERVER
    public function __construct(Config $config){
        $array=$config->asArray()+array(
			'host'=>'127.0.0.1',
			'port'=>'5672',
			'user'=>'guest',
			'password'=>'guest',
			'vhost'=> '/',
			'ssl'=> false,
			'insist' => false,//client is false ,server is true
			'login_method' => 'AMQPLAIN',
			'login_response' => null,
			'locale' => 'en_US',
			'connection_timeout' => 3.0,
			'read_write_timeout' => 3.0,
			'context' => null,
			'keepalive' => false,
			'heartbeat' => 0
		);
		extract($array);
		if ($ssl) $context= empty($context) ? null : $this->create_ssl_context($context);
		parent::__construct(
				$host,
				$port,
				$user,
				$password,
				$vhost,
				$insist,
				$login_method ,
				$login_response ,
				$locale ,
				$connection_timeout ,
				$read_write_timeout ,
				$context ,
				$keepalive ,
				$heartbeat);
	}
}