<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 10:46
 */
require_once '../entrance.php';

$openid = $_POST["openid"];
$name = $_POST["name"];
$career_type = $_POST["career_type"];
$company_nature = $_POST["company_nature"];
$location = $_POST["location"];
$contactor = $_POST["contactor"];
$tel = $_POST["tel"];
$email = $_POST["email"];
$descript = $_POST["descript"];
$update = $_POST["update"];

$dao = new company_dao();
if ($update) {
    $result = $dao->modify($openid, $name, $career_type, $company_nature, $location, $contactor, $tel, $email, $descript);
} else {
    $result = $dao->save($openid, $name, $career_type, $company_nature, $location, $contactor, $tel, $email, $descript);
}
$content = new result($result, errorCode::$success);
$json_string = json_encode($content, JSON_UNESCAPED_UNICODE);

?>
<?php
include("./include/save_complete.php");
?>
