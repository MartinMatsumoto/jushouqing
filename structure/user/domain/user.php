<?php

/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 9:50
 */
class user
{
    // id
    public $id;
    // 姓名
    public $name;
    // 性别
    public $sex;
    // 联系方式
    public $contact;
    // 入学时间
    public $school_date;
    // openId
    public $open_id;
    // 地区Id
    public $area;
    // 系别
    public $department;
    // 专业Id
    public $major;
    // 工作
    public $career;
    // 工作类型
    public $career_type;
    // 公司
    public $company;
    // 补充
    public $descript;
    //微信昵称
    public $wx_nickname;
    //微信性别
    public $wx_sex;
    //微信市
    public $wx_city;
    //微信省
    public $wx_province;
    //微信国家
    public $wx_country;
    //微信头像路径
    public $wx_headimgurl;

    //构造函数
    function __construct($row)
    {
        if (array_key_exists("id", $row)) {
            $this->id = $row["id"];
        }

        if (array_key_exists("name", $row)) {
            $this->name = $row["name"];
        }

        if (array_key_exists("sex", $row)) {
            $this->sex = $row["sex"];
        }

        if (array_key_exists("contact", $row)) {
            $this->contact = $row["contact"];
        }

        if (array_key_exists("school_date", $row)) {
            $this->school_date = $row["school_date"];
        }

        if (array_key_exists("openid", $row)) {
            $this->open_id = $row["openid"];
        }

        if (array_key_exists("area", $row)) {
            $this->area = $row["area"];
        }

        if (array_key_exists("department", $row)) {
            $this->department = $row["department"];
        }

        if (array_key_exists("major", $row)) {
            $this->major = $row["major"];
        }

        if (array_key_exists("career", $row)) {
            $this->career = $row["career"];
        }

        if (array_key_exists("career_type", $row)) {
            $this->career_type = $row["career_type"];
        }

        if (array_key_exists("company", $row)) {
            $this->company = $row["company"];
        }

        if (array_key_exists("descript", $row)) {
            $this->descript = $row["descript"];
        }

        if (array_key_exists("wx_nickname", $row)) {
            $this->wx_nickname = $row["wx_nickname"];
        }

        if (array_key_exists("wx_headimgurl", $row)) {
            $this->wx_headimgurl = $row["wx_headimgurl"];
        }

    }

}
