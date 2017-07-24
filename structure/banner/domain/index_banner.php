<?php

/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 9:50
 */
class index_banner
{
    // id
    public $id;
    // 背景图
    public $image_url;
    // 第一行字
    public $text1;
    // 第二行字
    public $text2;
    // 第三行字
    public $text3;
    // 第四行字
    public $text4;

    //构造函数
    function __construct($row)
    {
        if (array_key_exists("id", $row)) {
            $this->id = $row["id"];
        }

        if (array_key_exists("image_url", $row)) {
            $this->image_url = $row["image_url"];
        }

        if (array_key_exists("text1", $row)) {
            $this->text1 = $row["text1"];
        }

        if (array_key_exists("text2", $row)) {
            $this->text2 = $row["text2"];
        }

        if (array_key_exists("text3", $row)) {
            $this->text3 = $row["text3"];
        }

        if (array_key_exists("text4", $row)) {
            $this->text4 = $row["text4"];
        }

    }

}
