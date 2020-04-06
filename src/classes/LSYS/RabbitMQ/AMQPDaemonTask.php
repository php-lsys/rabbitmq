<?php
/**
 * lsys ribbatmq
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace LSYS\RabbitMQ;
use PhpAmqpLib\Channel\AMQPChannel;
abstract class AMQPDaemonTask{
	abstract public function bind(AMQPChannel $channel);
}