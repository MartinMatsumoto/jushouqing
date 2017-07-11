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

    private $saveUser = "INSERT INTO user(name,sex,contact,area_id,department_id,school_date,major_id,openid,custom_department,custom_major) VALUES (:name,:sex,:contact,:area_id,:department_id,:school_date,:major_id,:openid,:custom_department,:custom_major)";
    private $modifyUser = "UPDATE user SET `name` = :name,`sex` = :sex,`contact` = :contact,`area_id` = :area_id,`department_id` = :department_id,`custom_department` = :custom_department,`school_date` = :school_date,`major_id` = :major_id,`custom_major` = :custom_major WHERE openid = :openid";
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

    function save($name, $sex, $contact, $area_id, $department_id, $customDepartment, $school_date, $major_id, $customMajor, $openid)
    {

        if ($this->autOpenIdExist($openid)) {
            return false;
        }

        try {
            $stmt = $this->conn->pdo->prepare($this->saveUser);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':sex', $sex);
            $stmt->bindParam(':contact', $contact);
            $stmt->bindParam(':area_id', $area_id);
            $stmt->bindParam(':department_id', $department_id);
            $stmt->bindParam(':custom_department', $customDepartment);
            $stmt->bindParam(':school_date', $school_date);
            $stmt->bindParam(':major_id', $major_id);
            $stmt->bindParam(':custom_major', $customMajor);
            $stmt->bindParam(':openid', $openid);
            $stmt->execute();
        } catch (Exception  $e) {
            return false;
        }
        return true;
    }

    function modify($name, $sex, $contact, $area_id, $department_id, $customDepartment, $school_date, $major_id, $customMajor, $openid)
    {

        if (!$this->autOpenIdExist($openid)) {
            return false;
        }

        try {
            $stmt = $this->conn->pdo->prepare($this->modifyUser);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':sex', $sex);
            $stmt->bindParam(':contact', $contact);
            $stmt->bindParam(':area_id', $area_id);
            $stmt->bindParam(':department_id', $department_id);
            $stmt->bindParam(':custom_department', $customDepartment);
            $stmt->bindParam(':school_date', $school_date);
            $stmt->bindParam(':major_id', $major_id);
            $stmt->bindParam(':custom_major', $customMajor);
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