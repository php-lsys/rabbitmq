<?php

require_once __DIR__ . '/Bootstarp.php';
use PhpAmqpLib\Message\AMQPMessage;
$connection =new \LSYS\RabbitMQ();
$channel = $connection->channel();


$channel->queue_declare('hello', false, false, false, false,false,array(
	//'x-dead-letter-exchange'=>'dead-queue',
	//'x-dead-letter-routing-key'=>'xxx'
));


$msg = new AMQPMessage('hi',array(
	'expiration'=>	"60000"
));
$channel->basic_publish($msg, '', 'hello');

echo " [x] Sent 'Hello World!'\n";

$channel->close();
$connection->close();

?>