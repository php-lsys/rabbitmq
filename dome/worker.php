<?php
use PhpAmqpLib\Channel\AMQPChannel;
use LSYS\RabbitMQ\AMQPDaemonMgr;
use LSYS\RabbitMQ\AMQPDaemonTask;
require_once __DIR__ . '/Bootstarp.php';
class bb extends AMQPDaemonTask{
	public function callback($msg){
		//$msg->body或是其他数据...
	    $u=new Domefoo\UserDome;
		$u->mergeFromString($msg->body);
		echo ' [x] ', $u->getUserName(), "\n";
	}
	public function bind(AMQPChannel $channel){
		//绑定处理消息
		
		
		$channel->exchange_declare('logs', 'fanout', false, false, false);
		list($queue_name, ,) = $channel->queue_declare("", false, false, true, false);
		$channel->queue_bind($queue_name, 'logs');
		$channel->basic_consume($queue_name, '', false, true, false, false, array($this,'callback'));
	}
}
(new AMQPDaemonMgr(\LSYS\Config\DI::get()->config(\LSYS\RabbitMQ\DI::$config)))
//添加后台任务,有多个添加多个
->add_task(new bb(),2)
->listen();