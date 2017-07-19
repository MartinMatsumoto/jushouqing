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
$message = $_POST["message"];

$dao = new message_dao();
$dao->updateMessage($id, $openid, $message);

$content = new result(errorCode::$success, errorCode::$success);

$json_string = json_encode($content, JSON_UNESCAPED_UNICODE);
echo $json_string;