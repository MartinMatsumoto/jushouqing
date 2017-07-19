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
$result = $dao->listManager($begin, $size);
$arr = array();
while ($row = $result->fetch()) {
    $message = new message($row);
    array_push($arr, $message);
}

$content = new result($arr, errorCode::$success);

$json_string = json_encode($content, JSON_UNESCAPED_UNICODE);
echo $json_string;