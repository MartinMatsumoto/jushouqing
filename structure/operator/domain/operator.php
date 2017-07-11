<?php

/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 9:50
 */
class operator
{
    // id
    public $id;
    // 姓名
    public $account;
    // 密码
    private $password;
    // 创建日期
    public $create_date;
    // 真实姓名
    public $real_name;
    // 登录后key
    public $key;

    //构造函数
    function __construct($row)
    {
        if (array_key_exists("id", $row)) {
            $this->id = $row["id"];
        }

        if (array_key_exists("account", $row)) {
            $this->account = $row["account"];
        }

        if (array_key_exists("password", $row)) {
            $this->password = $row["password"];
        }

        if (array_key_exists("create_date", $row)) {
            $this->create_date = $row["create_date"];
        }

        if (array_key_exists("real_name", $row)) {
            $this->real_name = $row["real_name"];
        }

    }

}
