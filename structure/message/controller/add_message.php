<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/12/26
 * Time: 13:50
 */
require_once '../../../entrance.php';

$message = $_POST["message"];
$openId = $_POST["openId"];
$wx_nickname = $_POST["wx_nickname"];
$wx_headimgurl = $_POST["wx_headimgurl"];

$dao = new message_dao();
$recentId = $dao->addMessage($message, $openId, $wx_nickname, $wx_headimgurl);

$content = new result($recentId, errorCode::$success);

$json_string = json_encode($content, JSON_UNESCAPED_UNICODE);
echo $json_string;