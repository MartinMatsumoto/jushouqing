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

$dao = new company_dao();

$result = $dao->listCompanys($begin,$pageSize);
$arr = array();
while ($row = $result->fetch()) {
    $company = new company($row);
    array_push($arr, $company);
}
$content = new result($arr, errorCode::$success);

$countResult = $dao->count();
$countRow = $countResult->fetch();
$content->count = $countRow["COUNT"];

$json_string = json_encode($content, JSON_UNESCAPED_UNICODE);
echo $json_string;