<?php

/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 10:19
 */
class essay_content_dao
{
    private $conn;

    private $saveEssayContent = "INSERT INTO ESSAY_CONTENT(essay_id,content,type) VALUES (:essay_id,:content,:type)";
    private $modifyCompany = "UPDATE COMPANY SET `name` = :name,`career_type` = :career_type,`company_nature` = :company_nature,`location` = :location,`contactor` = :contactor,`tel` = :tel,`email` = :email,`descript` = :descript WHERE openid = :openid";
    private $getOne = "SELECT * FROM `COMPANY` WHERE openid = :openid";
    private $listEssayContents = "SELECT * FROM ESSAY_CONTENT WHERE essay_id = :id ";
    private $deleteAll = "DELETE FROM `ESSAY_CONTENT` WHERE essay_id = :essay_id";

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

    function save($essay_id, $content, $type)
    {

        try {
            $stmt = $this->conn->pdo->prepare($this->saveEssayContent);
            $stmt->bindParam(':essay_id', $essay_id);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':type', $type);
            $stmt->execute();
            return true;
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

    function listEssayContents($essay_id)
    {
        $stmt = $this->conn->pdo->prepare($this->listEssayContents);
        $stmt->bindParam(':id', $essay_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    function count()
    {
        $stmt = $this->conn->pdo->prepare($this->count);
        $stmt->execute();
        return $stmt;
    }

    function deleteAll($essay_id)
    {
        $stmt = $this->conn->pdo->prepare($this->deleteAll);
        $stmt->bindParam(':essay_id', $essay_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }
}