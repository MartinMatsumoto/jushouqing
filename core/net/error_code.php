<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/23
 * Time: 17:15
 */

class errorCode {

    static $success = 1;

    static $loginerror = -1;

    static $loginerrorstring = "账号不存在或密码错误";

    static $registererror = -2;

    static $favoriteexist = -3;

    static $unlogin = -99;

    static $accountexist = "账号已存在";

    static $emailexist = "邮箱已存在";

    static $registererrorstr = "注册失败";

    static $favoriteexiststr = "习题已收藏过啦";

    static $unloginstr = "用户未登录";
}