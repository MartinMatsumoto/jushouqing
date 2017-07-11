<?php

/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 10:19
 */
class operator_dao
{
    private $conn;

    private $login = "SELECT * FROM `operator` WHERE account = :account AND password = :password";

    //构造函数
    function __construct()
    {
        $this->conn = new connection_mysql();
    }

    function autExist($account,$password)
    {
        $stmt = $this->login($account,$password);
        while ($row = $stmt->fetch()) {
            $exist = true;
        }
        return $exist;
    }

    function login($account,$password)
    {
        $stmt = $this->conn->pdo->prepare($this->login);
        $stmt->bindParam(':account', $account);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        return $stmt;
    }

    function modify($name,$sex,$contact,$area_id,$department_id,$school_date,$major_id,$openid)
    {

        if(!$this->autOpenIdExist($openid)){
            return false;
        }

        try {
            $stmt = $this->conn->pdo->prepare($this->modifyUser);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':sex', $sex);
            $stmt->bindParam(':contact', $contact);
            $stmt->bindParam(':area_id', $area_id);
            $stmt->bindParam(':department_id', $department_id);
            $stmt->bindParam(':school_date', $school_date);
            $stmt->bindParam(':major_id', $major_id);
            $stmt->bindParam(':openid', $openid);
            $stmt->execute();
        } catch (Exception  $e) {
            return false;
        }
        return true;
    }

}