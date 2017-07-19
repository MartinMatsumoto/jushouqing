<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/12/26
 * Time: 18:36
 */
require_once '../../../entrance.php';

$id = intval($_POST["id"]);

$message_reply_dao = new message_reply_dao();

$replyResult = $message_reply_dao->listManager($id);
$arrReply = array();
while ($row = $replyResult->fetch()) {
    $message_reply = new message_reply($row);
    array_push($arrReply, $message_reply);
}
$content = new result($arrReply, errorCode::$success);

$json_string = json_encode($content, JSON_UNESCAPED_UNICODE);
echo $json_string;