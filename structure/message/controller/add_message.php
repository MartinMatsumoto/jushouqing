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

$dao = new message_dao();
$recentId = $dao->addMessage($message, $openId);

$content = new result($recentId, errorCode::$success);

$json_string = json_encode($content, JSON_UNESCAPED_UNICODE);
echo $json_string;