<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2017/7/13
 * Time: 12:53
 */
$user_data = file_get_contents("https://api.weixin.qq.com/sns/userinfo?access_token=" . $access_token . "&openid=" . $openid . "&lang=zh_CN");//拉取用户信息
$userjsoncode = json_decode($user_data); //对JSON格式的字符串进行编码
$userarray = get_object_vars($userjsoncode);//转换成数组

$nickname = '';
$sex = '';
$city = '';
$province = '';
$country = '';
$headimgurl = '';

if (array_key_exists("nickname", $userarray)) {
    $nickname = $userarray['nickname'];
}

if (array_key_exists("sex", $userarray)) {
    $sex = $userarray['sex'];
}

if (array_key_exists("city", $userarray)) {
    $city = $userarray['city'];
}

if (array_key_exists("province", $userarray)) {
    $province = $userarray['province'];
}

if (array_key_exists("country", $userarray)) {
    $country = $userarray['country'];
}

if (array_key_exists("headimgurl", $userarray)) {
    $headimgurl = $userarray['headimgurl'];
}
