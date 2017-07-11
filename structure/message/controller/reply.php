<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/12/26
 * Time: 12:55
 */
require_once '../../../entrance.php';

$reply = $_POST["reply"];
$openId = $_POST["openId"];
$messageId = $_POST["messageId"];

$dao = new message_reply_dao();
$result = $dao->reply($reply, $openId, $messageId);

$content = new result(errorCode::$success, errorCode::$success);

$json_string = json_encode($content, JSON_UNESCAPED_UNICODE);
echo $json_string;