<?php

/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 9:50
 */
class area
{
    // id
    public $id;
    // 父Id
    public $parent_id;
    // 地名
    public $name;
    //
    public $sort;

    //构造函数
    function __construct($row)
    {
        if (array_key_exists("id", $row)) {
            $this->id = $row["id"];
        }

        if (array_key_exists("parent_id", $row)) {
            $this->parent_id = $row["parent_id"];
        }

        if (array_key_exists("name", $row)) {
            $this->name = $row["name"];
        }

        if (array_key_exists("sort", $row)) {
            $this->sort = $row["sort"];
        }

    }

}
