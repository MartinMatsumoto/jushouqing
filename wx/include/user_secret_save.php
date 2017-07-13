<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2017/7/13
 * Time: 13:02
 */
$dao = new user_dao();

$dao->updateWxUserInfo($nickname, $sex, $city, $province, $country, $headimgurl, $openid);