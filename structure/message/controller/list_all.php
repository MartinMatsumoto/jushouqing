<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 10:46
 */
require_once '../../../entrance.php';

$pageSize = intval($_POST["pageSize"]);
$currentPage = intval($_POST["currentPage"]);

$dao = new message_dao();
$result = $dao->listAll($pageSize, $currentPage);

$arr = array();
while ($row = $result->fetch()) {
    $message = new message($row);
    array_push($arr, $message);
}

$content = new result($arr, errorCode::$success);

$json_string = json_encode($content, JSON_UNESCAPED_UNICODE);
echo $json_string;