<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 10:46
 */
require_once '../../../entrance.php';

$dao = new index_content_dao();

$result = $dao->listCompanyActive();
$arr = array();
while ($row = $result->fetch()) {
    $index_content = new index_content($row);
    array_push($arr, $index_content);
}
$content = new result($arr, errorCode::$success);

$json_string = json_encode($content, JSON_UNESCAPED_UNICODE);
echo $json_string;