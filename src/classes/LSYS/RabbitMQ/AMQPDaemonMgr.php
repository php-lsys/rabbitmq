<?php
/**
 * lsys ribbatmq
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace LSYS\RabbitMQ;
use LSYS\RabbitMQ;
use LSYS\Config;
class AMQPDaemonMgr
{
	protected $_run_user;
	protected $_run_group;
	protected $_pid_file;
	protected $_config;
	public function __construct(Config $config,$pid_file="amqp.pid",$run_user='nobody',$run_group='nobody'){
		$this->_run_user=$run_user;
		$this->_run_group=$run_group;
		$this->_pid_file=$pid_file;
		$this->_config=$config;
	}
	protected $_tasks=[];
	public function add_task($task,$num=1){
		while ($num-->0){
			$this->_tasks[]=$task;
		}
		return $this;
	}
	protected function _create_task(){
		$pid= pcntl_fork();
		if ($pid) return $pid;
		$run_user=$this->_run_user;
		$run_group=$this->_run_group;
		$userinfo = posix_getpwnam($run_user);
		if(isset($userinfo['uid'])) @posix_setuid($userinfo['uid']);
		$ginfo = posix_getgrnam($run_group);
		if(isset($ginfo['gid'])) @posix_setgid($ginfo['gid']);
		$conn=new RabbitMQ($this->_config);
		/**
		 * @var PhpAmqpLib\Channel\AMQPChannel $channel
		 */
		$channel=$conn->channel();
		$bind=$this->_tasks[$this->_index];
		$bind->bind($channel);
		while(count($channel->callbacks)) {
			$channel->wait();
		}
		$channel->close();
		$connection->close();
		exit;
	}
	protected function _create_monitor(){
		$pid_file=$this->_pid_file;
		if (is_file($pid_file))throw new \Exception("pid file is exist:{$pid_file}\n");
		$pid= pcntl_fork();
		if ($pid){
			file_put_contents($pid_file, $pid);
			return $pid;
		}
		while (true){sleep(60);}
		exit;
	}
	protected $_index;
	public function listen($is_deamon=true)
	{
		if($is_deamon)if(pcntl_fork()>0)die();
		$i=count($this->_tasks);
		if ($i==0)return ;
		$mp=$this->_create_monitor();
		$tps=[];
		while ($i-->0){
			$this->_index=$i;
			$tps[$this->_create_task()]=$i;
		}
		$is_run=true;
		while (true){
			$pid=pcntl_wait($status);
			switch ($pid){
				case -1: break 2;//关闭
				case $mp:
					if (pcntl_wifexited($status)){//正常退出
						$mp=$this->_create_monitor();
						break;
					}else if(pcntl_wifsignaled($status)){//信号退出
						$sig=pcntl_wtermsig($status);
						switch ($sig){
							case SIGINT:
								$is_run=false;
								foreach ($tps as $pid=>$v){
									posix_kill($pid, SIGINT);
								}
								break 2;
						}
					}
					break;
				default:
					$i=$tps[$pid];
					unset($tps[$pid]);
					$this->_index=$i;
					if ($is_run){
						sleep(2);
						$tps[$this->_create_task()]=$i;
					}
					break;
			}
		}
		if(is_file($this->_pid_file))unlink($this->_pid_file);
	}
}
