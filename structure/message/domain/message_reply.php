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
    // 回复的id
    public $reply_id;
    // 该回复的昵称
    public $wx_nickname;
    // 该回复的头像
    public $wx_headimgurl;
    // 创建日期
    public $create_date;
    // 被回复的openid
    public $reply_openid;
    // 被回复的头像
    public $reply_wx_headimgurl;
    // 被回复的昵称
    public $reply_wx_nickname;
    //该回复的用户名称
    public $name;
    //该回复的用户头像
    public $user_headimgurl;
    //被回复的用户名称
    public $reply_name;
    //被回复的用户头像
    public $reply_user_headimgurl;

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

        if (array_key_exists("reply_id", $row)) {
            $this->reply_id = $row["reply_id"];
        }

        if (array_key_exists("wx_nickname", $row)) {
            $this->wx_nickname = $row["wx_nickname"];
        }

        if (array_key_exists("wx_headimgurl", $row)) {
            $this->wx_headimgurl = $row["wx_headimgurl"];
        }

        if (array_key_exists("create_date", $row)) {
            $this->create_date = $row["create_date"];
        }

        if (array_key_exists("reply_openid", $row)) {
            $this->reply_openid = $row["reply_openid"];
        }

        if (array_key_exists("reply_wx_headimgurl", $row)) {
            $this->reply_wx_headimgurl = $row["reply_wx_headimgurl"];
        }

        if (array_key_exists("reply_wx_nickname", $row)) {
            $this->reply_wx_nickname = $row["reply_wx_nickname"];
        }

        if (array_key_exists("name", $row)) {
            $this->name = $row["name"];
        }

        if (array_key_exists("user_headimgurl", $row)) {
            $this->user_headimgurl = $row["user_headimgurl"];
        }

        if (array_key_exists("reply_name", $row)) {
            $this->reply_name = $row["reply_name"];
        }

        if (array_key_exists("reply_user_headimgurl", $row)) {
            $this->reply_user_headimgurl = $row["reply_user_headimgurl"];
        }
    }

}
