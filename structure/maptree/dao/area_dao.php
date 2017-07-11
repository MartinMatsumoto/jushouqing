<?php

/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 10:19
 */
class area_dao
{
    private $conn;
    private $getOne = "select * from area where id = :id";
    private $getCityProvince = "SELECT * FROM area WHERE id = (SELECT parent_id FROM area WHERE id = :city_id)";
    private $listByParent = "select * from area where parent_id = :id";

    //省父Id=0
    public $provinceParentId = 0;
    //四川Id
    public $sichuanId = 2700;

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

    /**
     * 根据市获得省
     * @param $cityId
     * @return PDOStatement
     */
    function getCityProvince($cityId)
    {
        $stmt = $this->conn->pdo->prepare($this->getCityProvince);
        $stmt->bindParam(':city_id', $cityId);
        $stmt->execute();
        return $stmt;
    }

    function listByProvince($parentId)
    {
        $stmt = $this->conn->pdo->prepare($this->listByParent);
        $stmt->bindParam(':id', $parentId);
        $stmt->execute();
        return $stmt;
    }

    function listProvince()
    {
        $stmt = $this->conn->pdo->prepare($this->listByParent);
        $stmt->bindParam(':id', $this->provinceParentId);
        $stmt->execute();
        return $stmt;
    }

}