<?php

/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 10:19
 */
class user_dao
{
    private $conn;

    private $saveUser = "INSERT INTO USER(name,sex,contact,openid,area,department,major,career,career_type,company,descript) VALUES (:name,:sex,:contact,:openid,:area,:department,:major,:career,:career_type,:company,:descript)";
    private $modifyUser = "UPDATE USER SET `name` = :name,`sex` = :sex,`contact` = :contact,`area` = :area,`department` = :department,`major` = :major,`career` = :career,`career_type` = :career_type,`company` = :company,`descript` = :descript WHERE openid = :openid
";
    private $getOne = "SELECT * FROM `user` WHERE openid = :openid";
    private $listUsers = "SELECT u.*,m.`name` AS major_name,d.`name` AS department_name,a.`name` AS area_name FROM `user` u LEFT JOIN major m ON u.major_id = m.id LEFT JOIN department d ON u.department_id = d.id LEFT JOIN area a ON u.area_id = a.id LIMIT :be ,:en ";
    private $count = "SELECT COUNT(*) AS COUNT from `user`";
    private $delete = "DELETE FROM `user` WHERE id = :id";

    //构造函数
    function __construct()
    {
        $this->conn = new connection_mysql();
    }

    function autOpenIdExist($openid)
    {
        $exist = false;
        $stmt = $this->getOne($openid);
        while ($row = $stmt->fetch()) {
            $exist = true;
        }

        return $exist;
    }

    function getOne($openid)
    {
        $stmt = $this->conn->pdo->prepare($this->getOne);
        $stmt->bindParam(':openid', $openid);
        $stmt->execute();
        return $stmt;
    }

    function save($name, $sex, $contact, $city, $department, $major, $career, $career_type, $company, $descript, $openid)
    {

        if ($this->autOpenIdExist($openid)) {
            return false;
        }

        try {
            $stmt = $this->conn->pdo->prepare($this->saveUser);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':sex', $sex);
            $stmt->bindParam(':contact', $contact);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':department', $department);
            $stmt->bindParam(':major', $major);
            $stmt->bindParam(':career', $career);
            $stmt->bindParam(':career_type', $career_type);
            $stmt->bindParam(':company', $company);
            $stmt->bindParam(':descript', $descript);
            $stmt->bindParam(':openid', $openid);
            $stmt->execute();
        } catch (Exception  $e) {
            return false;
        }
        return true;
    }

    function modify($name, $sex, $contact, $city, $department, $major, $career, $career_type, $company, $descript, $openid)
    {

        if (!$this->autOpenIdExist($openid)) {
            return false;
        }

        try {
            $stmt = $this->conn->pdo->prepare($this->modifyUser);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':sex', $sex);
            $stmt->bindParam(':contact', $contact);
            $stmt->bindParam(':area', $city);
            $stmt->bindParam(':department', $department);
            $stmt->bindParam(':major', $major);
            $stmt->bindParam(':career', $career);
            $stmt->bindParam(':career_type', $career_type);
            $stmt->bindParam(':company', $company);
            $stmt->bindParam(':descript', $descript);
            $stmt->bindParam(':openid', $openid);
            $stmt->execute();
        } catch (Exception  $e) {
            return false;
        }
        return true;
    }

    function listUsers($begin, $size)
    {
        $stmt = $this->conn->pdo->prepare($this->listUsers);
        $stmt->bindParam(':be', $begin, PDO::PARAM_INT);
        $stmt->bindParam(':en', $size, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    function count()
    {
        $stmt = $this->conn->pdo->prepare($this->count);
        $stmt->execute();
        return $stmt;
    }

    function delete($id)
    {
        $stmt = $this->conn->pdo->prepare($this->delete);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }
}