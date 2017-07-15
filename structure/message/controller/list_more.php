<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/12/26
 * Time: 18:36
 */
require_once '../../../entrance.php';

$begin = intval($_POST["begin"]);
$size = intval($_POST["pageSize"]);

$dao = new message_dao();
$message_reply_dao = new message_reply_dao();
$result = $dao->listMore($begin, $size);

$arr = array();
while ($row = $result->fetch()) {
    $message = new message($row);
    $replyResult = $message_reply_dao->listByMessage($message->id);
    $arrReply = array();
    while ($row = $replyResult->fetch()) {
        $message_reply = new message_reply($row);
        array_push($arrReply, $message_reply);
    }
    $message->replies = $arrReply;
    array_push($arr, $message);
}

$content = new result($arr, errorCode::$success);

$json_string = json_encode($content, JSON_UNESCAPED_UNICODE);
echo $json_string;