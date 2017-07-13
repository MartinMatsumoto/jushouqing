<?php

/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 9:50
 */
class message
{
    // id
    public $id;
    // openId
    public $openid;
    // 姓名
    public $message;
    // 性别
    public $create_date;
    // 联系方式
    public $delete_;
    // 姓名 来自用户
    public $name;
    //微信性别 来自用户
    public $sex;
    //微信昵称
    public $wx_nickname;
    //微信头像路径
    public $wx_headimgurl;
    //微信头像路径 来自用户
    public $user_wx_headimgurl;
    //构造函数
    function __construct($row)
    {
        if (array_key_exists("id", $row)) {
            $this->id = $row["id"];
        }

        if (array_key_exists("openid", $row)) {
            $this->openid = $row["openid"];
        }

        if (array_key_exists("message", $row)) {
            $this->message = $row["message"];
        }

        if (array_key_exists("create_date", $row)) {
            $this->create_date = $row["create_date"];
        }

        if (array_key_exists("delete_", $row)) {
            $this->delete_ = $row["delete_"];
        }

        if (array_key_exists("id", $row)) {
            $this->id = $row["id"];
        }

        if (array_key_exists("name", $row)) {
            $this->name = $row["name"];
        }

        if (array_key_exists("sex", $row)) {
            $this->sex = $row["sex"];
        }

        if (array_key_exists("wx_nickname", $row)) {
            $this->wx_nickname = $row["wx_nickname"];
        }

        if (array_key_exists("wx_headimgurl", $row)) {
            $this->wx_headimgurl = $row["wx_headimgurl"];
        }

        if (array_key_exists("user_wx_headimgurl", $row)) {
            $this->user_wx_headimgurl = $row["user_wx_headimgurl"];
        }
    }

}
