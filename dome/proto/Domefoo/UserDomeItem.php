<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: proto_dome/src/domeuser.proto

namespace Domefoo;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * <pre>
 *类注释:用户ITEM
 * </pre>
 *
 * Protobuf type <code>domefoo.UserDomeItem</code>
 */
class UserDomeItem extends \Google\Protobuf\Internal\Message
{
    /**
     * <pre>
     *测试ITEM ID
     * </pre>
     *
     * <code>int32 item_id = 1;</code>
     */
    private $item_id = 0;
    /**
     * <pre>
     *测试ITEM NAME
     * </pre>
     *
     * <code>string item_name = 2;</code>
     */
    private $item_name = '';

    public function __construct() {
        \GPBMetadata\ProtoDome\Src\Domeuser::initOnce();
        parent::__construct();
    }

    /**
     * <pre>
     *测试ITEM ID
     * </pre>
     *
     * <code>int32 item_id = 1;</code>
     */
    public function getItemId()
    {
        return $this->item_id;
    }

    /**
     * <pre>
     *测试ITEM ID
     * </pre>
     *
     * <code>int32 item_id = 1;</code>
     */
    public function setItemId($var)
    {
        GPBUtil::checkInt32($var);
        $this->item_id = $var;
    }

    /**
     * <pre>
     *测试ITEM NAME
     * </pre>
     *
     * <code>string item_name = 2;</code>
     */
    public function getItemName()
    {
        return $this->item_name;
    }

    /**
     * <pre>
     *测试ITEM NAME
     * </pre>
     *
     * <code>string item_name = 2;</code>
     */
    public function setItemName($var)
    {
        GPBUtil::checkString($var, True);
        $this->item_name = $var;
    }

}

