<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2017/1/11
 * Time: 10:16
 */
$code = $_GET['code'];//获取code
$weixin = file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx2301da7d30fe75e1&secret=cd084b80becbdfa8a4d3f18ca3915427&code=" . $code . "&grant_type=authorization_code");//通过code换取网页授权access_token
$jsondecode = json_decode($weixin); //对JSON格式的字符串进行编码
$array = get_object_vars($jsondecode);//转换成数组
$openid = $array['openid'];//输出openid