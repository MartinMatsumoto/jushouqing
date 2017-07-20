<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/12/26
 * Time: 12:55
 */
require_once '../../../entrance.php';

$openid = $_POST["openid"];
$id = $_POST["id"];
$reply = $_POST["reply"];

$dao = new message_reply_dao();
$dao->updateReply($id, $openid, $reply);

$content = new result(errorCode::$success, errorCode::$success);

$json_string = json_encode($content, JSON_UNESCAPED_UNICODE);
echo $json_string;