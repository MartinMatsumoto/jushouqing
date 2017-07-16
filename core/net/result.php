<?php

/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/23
 * Time: 17:10
 */

class result
{
    public $errorString;

    public $errorCode;

    public $content;

    public $count;

    public $success;

    function __construct($content,$errorCode)
    {
        if($errorCode == errorCode::$success){
            $this->success = true;
        }
        $this->errorCode = $errorCode;
        $this->content = $content;
    }

}