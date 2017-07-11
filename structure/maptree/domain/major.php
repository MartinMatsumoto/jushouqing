<?php

/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 9:50
 */
class major
{
    // id
    public $id;
    // 地名
    public $name;
    //
    public $department_id;

    //构造函数
    function __construct($row)
    {
        if (array_key_exists("id", $row)) {
            $this->id = $row["id"];
        }

        if (array_key_exists("name", $row)) {
            $this->name = $row["name"];
        }

        if (array_key_exists("department_id", $row)) {
            $this->department_id = $row["department_id"];
        }

    }

}
