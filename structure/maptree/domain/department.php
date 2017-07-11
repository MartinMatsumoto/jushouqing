<?php

/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 9:50
 */
class department
{
    // id
    public $id;
    // 名字
    public $name;

    //构造函数
    function __construct($row)
    {
        if (array_key_exists("id", $row)) {
            $this->id = $row["id"];
        }

        if (array_key_exists("name", $row)) {
            $this->name = $row["name"];
        }

    }

}
