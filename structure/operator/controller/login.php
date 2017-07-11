<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/12/28
 * Time: 16:45
 */
require_once '../../../entrance.php';

$account = $_POST["account"];
$password = $_POST["password"];

$dao = new operator_dao();
$result = $dao->login($account, $password);

while ($row = $result->fetch()) {
    $operator = new operator($row);
}
if (empty($operator)) {
    $content = new manager_result(null, errorCode::$loginerror);
    $content->errorString = errorCode::$loginerrorstring;
} else {
    $ip = $_SERVER["REMOTE_ADDR"];
    $key = $ip . $operator->id;
    $operator->key = sha1($key);
    $content = new manager_result($operator, errorCode::$success);
}

$json_string = json_encode($content, JSON_UNESCAPED_UNICODE);
echo $json_string;