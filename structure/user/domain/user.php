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
    // 地区Id
    public $area_id;
    // 系别
    public $department_id;
    // 入学时间
    public $school_date;
    // 专业Id
    public $major_id;
    // 自定义专业
    public $custom_major;
    // 自定义系别
    public $custom_department;
    // openId
    public $open_id;
    // 专业名称
    public $major_name;
    // 系别名称
    public $department_name;
    // 地区名称
    public $area_name;

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

        if (array_key_exists("area_id", $row)) {
            $this->area_id = $row["area_id"];
        }

        if (array_key_exists("department_id", $row)) {
            $this->department_id = $row["department_id"];
        }

        if (array_key_exists("school_date", $row)) {
            $this->school_date = $row["school_date"];
        }

        if (array_key_exists("department_id", $row)) {
            $this->department_id = $row["department_id"];
        }

        if (array_key_exists("major_id", $row)) {
            $this->major_id = $row["major_id"];
        }

        if (array_key_exists("custom_department", $row)) {
            $this->custom_department = $row["custom_department"];
        }

        if (array_key_exists("custom_major", $row)) {
            $this->custom_major = $row["custom_major"];
        }

        if (array_key_exists("openid", $row)) {
            $this->open_id = $row["openid"];
        }

        if (array_key_exists("major_name", $row)) {
            $this->major_name = $row["major_name"];
        }

        if (array_key_exists("department_name", $row)) {
            $this->department_name = $row["department_name"];
        }

        if (array_key_exists("area_name", $row)) {
            $this->area_name = $row["area_name"];
        }
    }

}
