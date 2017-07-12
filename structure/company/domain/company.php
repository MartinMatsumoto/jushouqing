<?php

/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 9:50
 */
class company
{
    // id
    public $id;
    // openId
    public $open_id;
    // 姓名
    public $name;
    // 行业类别
    public $career_type;
    // 企业性质
    public $company_nature;
    // 办公地址
    public $location;
    // 联系人
    public $contactor;
    // 联系电话
    public $tel;
    // 邮箱
    public $email;
    // 补充
    public $descript;

    //构造函数
    function __construct($row)
    {
        if (array_key_exists("id", $row)) {
            $this->id = $row["id"];
        }

        if (array_key_exists("openid", $row)) {
            $this->open_id = $row["openid"];
        }

        if (array_key_exists("name", $row)) {
            $this->name = $row["name"];
        }

        if (array_key_exists("career_type", $row)) {
            $this->career_type = $row["career_type"];
        }

        if (array_key_exists("company_nature", $row)) {
            $this->company_nature = $row["company_nature"];
        }

        if (array_key_exists("location", $row)) {
            $this->location = $row["location"];
        }

        if (array_key_exists("contactor", $row)) {
            $this->contactor = $row["contactor"];
        }

        if (array_key_exists("tel", $row)) {
            $this->tel = $row["tel"];
        }

        if (array_key_exists("email", $row)) {
            $this->email = $row["email"];
        }

        if (array_key_exists("descript", $row)) {
            $this->descript = $row["descript"];
        }

    }

}
