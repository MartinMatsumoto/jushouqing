<?php

/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/23
 * Time: 17:10
 */

class manager_result
{
    public $errorString;

    public $content;

    public $count;

    public $success;

    function __construct($content,$errorCode)
    {
        $this->content = $content;
        $this->success = $errorCode;
    }

}