<?php

/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 10:19
 */
class essay_dao
{
    private $conn;

    private $saveEssay = "INSERT INTO ESSAY(title,author,create_date,sub_title,type) VALUES (:title,:author,:create_date,:sub_title,:type)";
    private $modifyCompany = "UPDATE ESSAY SET `name` = :name,`career_type` = :career_type,`company_nature` = :company_nature,`location` = :location,`contactor` = :contactor,`tel` = :tel,`email` = :email,`descript` = :descript WHERE openid = :openid";
    private $getOne = "SELECT * FROM `ESSAY` WHERE id = :id";
    private $count = "SELECT COUNT(*) AS COUNT from `COMPANY`";
    private $delete = "UPDATE `ESSAY` SET delete_ = 1 WHERE id = :id";

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

    function getOne($id)
    {
        $stmt = $this->conn->pdo->prepare($this->getOne);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt;
    }

    function save($type, $title, $author, $create_date, $sub_title)
    {

        try {
            $stmt = $this->conn->pdo->prepare($this->saveEssay);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':author', $author);
            $stmt->bindParam(':create_date', $create_date);
            $stmt->bindParam(':sub_title', $sub_title);
            $stmt->execute();

            $recentId = $stmt = $this->conn->pdo->lastInsertId();
            return $recentId;
        } catch (Exception  $e) {
            return false;
        }
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

    function listEssays($begin, $size, $type)
    {
        $listEssays = "SELECT * FROM ESSAY WHERE 1=1 ";
        if(!empty($type)){
            $listEssays .= " AND type = :type";
        }
        $listEssays .= " LIMIT :be ,:en ";
        $stmt = $this->conn->pdo->prepare($listEssays);
        $stmt->bindParam(':be', $begin, PDO::PARAM_INT);
        $stmt->bindParam(':en', $size, PDO::PARAM_INT);
        if(!empty($type)){
            $stmt->bindParam(':type', $type, PDO::PARAM_INT);
        }
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