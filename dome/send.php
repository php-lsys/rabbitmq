<?php
require_once __DIR__ . '/Bootstarp.php';
use PhpAmqpLib\Message\AMQPMessage;
use LSYS\RabbitMQ\DI;
$channel= DI::get()->rabbitmq()->channel();
// direct, topic 和fanout
$channel->exchange_declare('logs', 'fanout', false, false, false);


//创建传递对象
$u=new Domefoo\UserDome();
$u->setUserName("name");
$data = $u->serializeToString();
//data 或其他数据...
//$data="";

//发送消息
$channel->basic_publish(new AMQPMessage($data), 'logs');
echo " [x] is Sent \n";

