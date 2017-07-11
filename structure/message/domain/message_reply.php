<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/12/26
 * Time: 10:20
 */
class message_reply
{
    // id
    public $id;
    // 回复内容
    public $reply;
    // openId
    public $openid;
    // 是否删除
    public $delete_;
    // 回复信息Id
    public $message_id;

    //构造函数
    function __construct($row)
    {
        if (array_key_exists("id", $row)) {
            $this->id = $row["id"];
        }

        if (array_key_exists("reply", $row)) {
            $this->reply = $row["reply"];
        }

        if (array_key_exists("openid", $row)) {
            $this->openid = $row["openid"];
        }

        if (array_key_exists("delete_", $row)) {
            $this->delete_ = $row["delete_"];
        }

        if (array_key_exists("message_id", $row)) {
            $this->message_id = $row["message_id"];
        }

    }

}
