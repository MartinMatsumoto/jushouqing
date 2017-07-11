<?php

/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 10:19
 */
class major_dao
{
    private $conn;
    private $getOne = "select * from major where id = :id";
    private $listByDepartment = "select * from major where department_id = :id";
    private $listBySiblings = "SELECT * FROM major WHERE department_id = (SELECT department_id FROM major WHERE id = :major_id)";

    //学科根
    public $desciplineRoot = 2;
    //学段根
    public $gradeRoot = 3;
    //题型根
    public $praxisType = 16;

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

    function listByParent($parentId)
    {
        $stmt = $this->conn->pdo->prepare($this->listByDepartment);
        $stmt->bindParam(':id', $parentId);
        $stmt->execute();
        return $stmt;
    }

    function listBySiblings($majorId)
    {
        $stmt = $this->conn->pdo->prepare($this->listBySiblings);
        $stmt->bindParam(':major_id', $majorId);
        $stmt->execute();
        return $stmt;
    }

}