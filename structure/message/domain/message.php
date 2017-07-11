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
    }

}
