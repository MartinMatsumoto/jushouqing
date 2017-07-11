<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 10:46
 */
require_once '../../../entrance.php';

$begin = intval($_POST["begin"]);
$pageSize = intval($_POST["pageSize"]);

$dao = new user_dao();

$result = $dao->listUsers($begin,$pageSize);
$arr = array();
while ($row = $result->fetch()) {
    $user = new user($row);
    array_push($arr, $user);
}
$content = new result($arr, errorCode::$success);

$countResult = $dao->count();
$countRow = $countResult->fetch();
$content->count = $countRow["COUNT"];

$json_string = json_encode($content, JSON_UNESCAPED_UNICODE);
echo $json_string;