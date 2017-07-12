<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 10:46
 */
require_once '../entrance.php';

$name = $_POST["name"];
$sex = intval($_POST["sex"]);
$contact = $_POST["contact"];
$city = $_POST["city"];
$department = $_POST["department"];
$major = intval($_POST["major"]);
$career = intval($_POST["career"]);
$career_type = $_POST["career_type"];
$company = $_POST["company"];
$descript = $_POST["descript"];
$openId = $_POST["openId"];
$update = $_POST["update"];

$dao = new user_dao();
if (empty($update)) {
    $result = $dao->save($name, $sex, $contact, $city, $department, $major, $career, $career_type, $company, $descript, $openId);
} else {
    $result = $dao->modify($name, $sex, $contact, $city, $department, $major, $career, $career_type, $company, $descript, $openId);
}

$content = new result($result, errorCode::$success);
$json_string = json_encode($content, JSON_UNESCAPED_UNICODE);

?>
<?php
include("./include/save_complete.php");
?>
