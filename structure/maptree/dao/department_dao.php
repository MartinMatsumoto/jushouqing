<?php

/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 10:19
 */
class department_dao
{
    private $conn;
    private $getOne = "select * from department where id = :id";
    private $listAll = "select * from department";
    private $listUseful = "select * from department where status = 0";
    private $listDividers = "SELECT `name` FROM department GROUP BY `name` ORDER BY `name` DESC";

    //人文科学root
    public $renwenkexueRoot = 1;

    //构造函数
    function __construct()
    {
        $this->conn = new connection_mysql();
    }

    function getOne($id)
    {
        $stmt = $this->conn->pdo->prepare($this->getOne);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt;
    }

    function listUseful()
    {
        $stmt = $this->conn->pdo->prepare($this->listUseful);
        $stmt->execute();
        return $stmt;
    }

    function listAll()
    {
        $stmt = $this->conn->pdo->prepare($this->listAll);
        $stmt->execute();
        return $stmt;
    }

    function listDividers()
    {
        $stmt = $this->conn->pdo->prepare($this->listDividers);
        $stmt->execute();
        return $stmt;
    }

}