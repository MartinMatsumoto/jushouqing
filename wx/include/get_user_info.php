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
$nickname = $userarray['nickname'];
$sex = $userarray['sex'];
$city = $userarray['city'];
$province = $userarray['province'];
$country = $userarray['country'];
$headimgurl = $userarray['headimgurl'];