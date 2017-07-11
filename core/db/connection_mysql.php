<?php

/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 10:10
 */
class connection_mysql
{
//主机
    private $host = "localhost:3306";
    //数据库的username
    private $name = "root";
    //数据库的password
    private $pass = "";
    //数据库名称
    private $table = "jushouqing";
    //编码形式
    private $ut = "UTF8";

    public $pdo;

    function __construct()
    {
        $this->pdo = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->table, $this->name, $this->pass);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec('set names ' . $this->ut);
    }

}