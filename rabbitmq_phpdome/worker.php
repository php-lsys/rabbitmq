<?php

require_once __DIR__ . '/Bootstarp.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Channel\AMQPChannel;



$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$call=function ()use($connection){
	$channel=$connection->channel();
	$channel->queue_declare('task_queue', false, true, false, false);
	
	echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";
	
	$callback = function($msg){
		echo " [x] Received ", $msg->body, "\n";
		//sleep(substr_count($msg->body, '.'));
		echo " [x] Done", "\n";
		//  if ($msg->body==='bbb')throw new Exception("dd");
		$msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
		//$msg->delivery_info['channel']->basic_nack($msg->delivery_info['delivery_tag']);
	};
	$channel->basic_qos(null, 1, null);
	$channel->basic_consume('task_queue', '', false, false, false, false, $callback);
	return $channel;
};
/**
 * @var AMQPChannel $channel
 */
$channel=$call();
while(count($channel->callbacks)) {
	try{
    	$channel->wait();
	}catch (ErrorException $e){
		if (strpos($e->getMessage(), "errno=10054")===false)throw $e;
		echo $e->getMessage()."\n";
		while (true){
			try{
				$connection->reconnect();
				break;
			}catch (ErrorException $e){
				if (strpos($e->getMessage(), "unable to connect")===false)throw $e;
				sleep(3);
				echo $e->getMessage()."\n";
			}
		}
		$channel=$call();
	}
}

$channel->close();
$connection->close();

?>