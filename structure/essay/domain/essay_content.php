<?php

/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 9:50
 */
class essay_content
{
    // id
    public $id;
    // 文章标题
    public $essay_id;
    // 文章作者
    public $content;
    // 文章创建时间
    public $type;

    //构造函数
    function __construct($row)
    {
        if (array_key_exists("id", $row)) {
            $this->id = $row["id"];
        }

        if (array_key_exists("essay_id", $row)) {
            $this->essay_id = $row["essay_id"];
        }

        if (array_key_exists("content", $row)) {
            $this->content = $row["content"];
        }

        if (array_key_exists("type", $row)) {
            $this->type = $row["type"];
        }

    }

}
