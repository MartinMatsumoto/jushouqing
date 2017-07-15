<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/12/26
 * Time: 12:55
 */
require_once '../../../entrance.php';

$openId = $_POST["openId"];
$messageId = $_POST["messageId"];

$dao = new message_dao();
$dao->delete($messageId, $openId);

$content = new result(errorCode::$success, errorCode::$success);

$json_string = json_encode($content, JSON_UNESCAPED_UNICODE);
echo $json_string;