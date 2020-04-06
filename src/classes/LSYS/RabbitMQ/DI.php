<?php
namespace LSYS\RabbitMQ;
/**
 * @method \LSYS\RabbitMQ rabbitmq($config=null)
 */
class DI extends \LSYS\DI{
    /**
     *
     * @var string default config
     */
    public static $config = 'rabitmq.default';
    /**
     * @return static
     */
    public static function get(){
        $di=parent::get();
        !isset($di->rabbitmq)&&$di->rabbitmq(new \LSYS\DI\ShareCallback(function($config=null){
            return $config?$config:self::$config;
        },function($config=null){
            $config=\LSYS\Config\DI::get()->config($config?$config:self::$config);
            return new \LSYS\RabbitMQ($config);
        }));
        return $di;
    }
}