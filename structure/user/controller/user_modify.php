<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 10:46
 */
require_once '../../../entrance.php';

$cityId = intval($_POST["cityId"]);
$customDepartment = $_POST["customDepartment"];
$contact = $_POST["contact"];
$customMajor = $_POST["customMajor"];
$departmentId = intval($_POST["departmentId"]);
$globalDate = $_POST["globalDate"];
$majorId = intval($_POST["majorId"]);
$name = $_POST["name"];
$openId = $_POST["openId"];
$sex = $_POST["sex"];


$dao = new user_dao();
$result = $dao->modify($name, $sex, $contact, $cityId, $departmentId, $customDepartment, $globalDate, $majorId, $customMajor, $openId);

$content = new result($result, errorCode::$success);

$json_string = json_encode($content, JSON_UNESCAPED_UNICODE);
echo $json_string;