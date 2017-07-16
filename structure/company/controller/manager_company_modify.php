<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 10:46
 */
require_once '../../../entrance.php';


$name = $_POST["name"];
$sex = intval($_POST["sex"]);
$contact = $_POST["contact"];
$city = $_POST["area"];
$department = $_POST["department"];
$major = $_POST["major"];
$career = $_POST["career"];
$career_type = $_POST["career_type"];
$company = $_POST["company"];
$descript = $_POST["descript"];
$openid = $_POST["open_id"];

$dao = new user_dao();
$result = $dao->modify($name, $sex, $contact, $city, $department, $major, $career, $career_type, $company, $descript, $openid);
$content = new result($result, errorCode::$success);
$json_string = json_encode($content, JSON_UNESCAPED_UNICODE);
echo $json_string;