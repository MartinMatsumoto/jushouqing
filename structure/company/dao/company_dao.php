<?php

/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 10:19
 */
class company_dao
{
    private $conn;

    private $saveCompany = "INSERT INTO COMPANY(openid,name,career_type,company_nature,location,contactor,tel,email,descript) VALUES (:openid,:name,:career_type,:company_nature,:location,:contactor,:tel,:email,:descript)";
    private $modifyCompany = "UPDATE COMPANY SET `name` = :name,`career_type` = :career_type,`company_nature` = :company_nature,`location` = :location,`contactor` = :contactor,`tel` = :tel,`email` = :email,`descript` = :descript WHERE openid = :openid";
    private $getOne = "SELECT * FROM `COMPANY` WHERE openid = :openid";
    private $listCompanys = "SELECT * FROM COMPANY LIMIT :be ,:en ";
    private $count = "SELECT COUNT(*) AS COUNT from `COMPANY`";
    private $delete = "DELETE FROM `COMPANY` WHERE id = :id";

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

    function save($openid, $name, $career_type, $company_nature, $location, $contactor, $tel, $email, $descript)
    {

        if ($this->autOpenIdExist($openid)) {
            return false;
        }

        try {
            $stmt = $this->conn->pdo->prepare($this->saveCompany);
            $stmt->bindParam(':openid', $openid);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':career_type', $career_type);
            $stmt->bindParam(':company_nature', $company_nature);
            $stmt->bindParam(':location', $location);
            $stmt->bindParam(':contactor', $contactor);
            $stmt->bindParam(':tel', $tel);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':descript', $descript);
            $stmt->execute();
        } catch (Exception  $e) {
            return false;
        }
        return true;
    }

    function modify($openid, $name, $career_type, $company_nature, $location, $contactor, $tel, $email, $descript)
    {

        if (!$this->autOpenIdExist($openid)) {
            return false;
        }

        try {
            $stmt = $this->conn->pdo->prepare($this->modifyCompany);
            $stmt->bindParam(':openid', $openid);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':career_type', $career_type);
            $stmt->bindParam(':company_nature', $company_nature);
            $stmt->bindParam(':location', $location);
            $stmt->bindParam(':contactor', $contactor);
            $stmt->bindParam(':tel', $tel);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':descript', $descript);
            $stmt->execute();
        } catch (Exception  $e) {
            return false;
        }
        return true;
    }

    function listUsers($begin, $size)
    {
        $stmt = $this->conn->pdo->prepare($this->listCompanys);
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