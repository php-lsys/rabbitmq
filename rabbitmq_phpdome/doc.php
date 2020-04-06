<?php
#流程
//发送消息 -> 交换器[未指定默认交换器,按队列名(派发到指定队列)] -[按规则,直接,主题,消息头,广播]-> 队列[临时队列] -> 处理消息

#代码要点:
//发送消息[只管发,不存在队列概念]
//创建交换机:
//1. 广播 - 所有注册队列收到一个消息副本
//2. 直接 - 等于路由的队列收到一个消息副本
//3. 主题 - 监听路由[info.*],发送路由[info.err]将收到一个消息副本
//默认交换机
//1. 根据路由名路由到对应队列

//接受消息[只管接,通过创建队列来接]
//无名队列[临时]
//1. 一般不做持久化,不加负载
//2. 绑定交换机,设置路由,接受消息
//有名队列[临时]
//1. 持久化自定,可加负载
//2. 绑定交换机,设置路由,或等待默认交换机消息

#延时消息
//发送过期消息到指定队列 队列配置超时转发 -> 超时消息进入超时处理队列 -> 处理消息
//message 超时
//'expiration'  => 60000//毫秒
//queue 超时默认
//'x-message-ttl'  => 60000//毫秒
//队列超时设置
//'x-dead-letter-exchange'=>'dead-queue',
//'x-dead-letter-routing-key'=>'xxx'



#消息体: AMQPMessage
// 'content_type' => 'shortstr',
// 'content_encoding' => 'shortstr',
// 'application_headers' => 'table_object',
// 'delivery_mode' => 'octet',//是否持久化
// 'priority' => 'octet',//优先级
// 'correlation_id' => 'shortstr',//RPC回复标识请求ID
// 'reply_to' => 'shortstr',//RPC回复临时队列名
// 'expiration' => 'shortstr',
// 'message_id' => 'shortstr',
// 'timestamp' => 'timestamp',
// 'type' => 'shortstr',
// 'user_id' => 'shortstr',
// 'app_id' => 'shortstr',
// 'cluster_id' => 'shortstr',

#方法注释
//AMQPChannel 推送 
function basic_publish(
	$msg,//消息内容
	$exchange = '',//交换机名
	$routing_key = '',//路由字符
	$mandatory = false,//如果exchange通过routeKey无法符合queue，调用basic.return方法将消息返还给生产者；当mandatory设为false时，将消息扔掉
	$immediate = false,//如果exchange在将消息route到queue(s)时发现对应的queue上没有消费者，那么这条消息不会放入队列中。当与消息routeKey关联的所有queue(一个或多个)都没有消费者时，该消息会通过basic.return方法返还给生产者
	$ticket = null
){}
//AMQPChannel 交换机
function exchange_declare(
		$exchange,//交换机名,存在跳过,不存在建立,存在且配置不同出错
		$type,//规则direct 按路由字符相等 topic 按路由字符匹配 fanout 全体广播  headers
		$passive = false,//设为true，如果该队列已存在，则会返回true；如果不存在，则会返回Error，但是不会创建新的队列
		$durable = false,//交换机是否持久化
		$auto_delete = true,//是否自动删除,链接断开时删除,临时交换机使用
		$internal = false,//这里Internal设置为false，否则将无法接受dead letter，true表示这个exchange不可以被client用来推送消息
        $nowait = false,
        $arguments = null,
        $ticket = null
){}
//AMQPChannel 负载设置
function basic_qos(
	$prefetch_size, 
	$prefetch_count,//每次负载数量 
	$a_global
){}
//AMQPChannel 队列获取
function queue_declare(
		$queue = '',//队列名,为空创建临时队列
		$passive = false,//设为true，如果该队列已存在，则会返回true；如果不存在，则会返回Error，但是不会创建新的队列.判断队列是否存在使用
		$durable = false,//是否持久化
		$exclusive = false,//排他队列，如果一个队列被声明为排他队列，该队列仅对首次声明它的连接可见，并在连接断开时自动删除。这里需要注意三点：其一，排他队列是基于连接可见的，同一连接的不同信道是可以同时访问同一个连接创建的排他队列的。其二，“首次”，如果一个连接已经声明了一个排他队列，其他连接是不允许建立同名的排他队列的，这个与普通队列不同。其三，即使该队列是持久化的，一旦连接关闭或者客户端退出，该排他队列都会被自动删除的。这种队列适用于只限于一个客户端发送读取消息的应用场景
		$auto_delete = true,//自动删除，如果该队列没有任何订阅的消费者的话，该队列会被自动删除。这种队列适用于临时队列
		$nowait = false,
		$arguments = null,
		$ticket = null
) {}
//AMQPChannel 绑定交换机和队列
function queue_bind(
		$queue, //路由名
		$exchange, //交换机名
		$routing_key = '',//路由字符 
		$nowait = false, 
		$arguments = null, 
		$ticket = null
){}
//AMQPChannel 队列监听
function basic_consume(
		$queue = '',//队列名
		$consumer_tag = '',//用户标识符，在当前通道中有效。
		$no_local = false,
		$no_ack = false,//是否自动确认
		$exclusive = false,//独占指定队列,不可被其他监听
		$nowait = false,
		$callback = null,//回调函数
		$ticket = null,
		$arguments = array()
) {}