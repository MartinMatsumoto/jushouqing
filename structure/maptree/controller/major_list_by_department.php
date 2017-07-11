<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 10:46
 */
require_once '../../../entrance.php';

$id = intval($_POST["parentId"]);

$dao = new major_dao();
$result = $dao->listByParent($id);

$json_string;
$arr = array();
while ($row = $result->fetch()) {
    $major = new major($row);
    array_push($arr, $major);
}

$content = new result($arr, errorCode::$success);

$json_string = json_encode($content, JSON_UNESCAPED_UNICODE);
echo $json_string;