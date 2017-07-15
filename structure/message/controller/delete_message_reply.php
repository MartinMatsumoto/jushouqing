<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/12/26
 * Time: 12:55
 */
require_once '../../../entrance.php';

$openId = $_POST["openId"];
$replyId = $_POST["replyId"];

$dao = new message_reply_dao();
$dao->delete($replyId, $openId);

$content = new result(errorCode::$success, errorCode::$success);

$json_string = json_encode($content, JSON_UNESCAPED_UNICODE);
echo $json_string;