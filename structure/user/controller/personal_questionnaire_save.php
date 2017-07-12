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
$tel = $_POST["tel"];
$city = $_POST["city"];
$department = $_POST["department"];
$major = intval($_POST["major"]);
$career = intval($_POST["career"]);
$career_type = $_POST["career_type"];
$company = $_POST["company"];
$descript = $_POST["descript"];

echo $name;

