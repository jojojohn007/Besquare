<?php

namespace App\Models;

use Core\View;
use PDO;

class User extends \Core\Model
{
    public static object $queryModel;

    public static function __callStatic($name, $arguments)
    {
        self::$queryModel = new QueryModel;
    }
    public static function queryAction($query)
    {
        try {
            $db = static::getDb();
            $stmt = $db->query($query);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $th) {
            echo $th->getMessage();
        }
    }


    public static function getAll($useremail)
    {
        $query  = "SELECT * FROM  `users` WHERE email='$useremail'";
        return static::queryAction($query);
    }

    public static function getCourseData(string $usersfullname)
    {

        // vd($usersfullname);
        $query = "SELECT * FROM $usersfullname";
        // return static::queryAction($query);
        // 
        $querymodel = new QueryModel();
        return ($querymodel->queryAction($query));
        unset($querymodel);
    }





  

    public  function tableWith(string $tablename, string $where, string $whereWhat)
    {


        $query = " SELECT   * FROM `$tablename` WHERE  `$tablename`.`$where` = '" . $whereWhat . "'  ";
        // $query = "SELECT COUNT(*) FROM `$tablename` WHERE `$tablename`.`$where` = '$whereWhat'";

        // vd(static::queryAction($query));

        $res = (static::queryAction($query));
        // vd($res);
        if($res == null){
            return false;
        }
        return count($res);
    }


    public static function getTableRowCount(string $tablename ,string $classname):int
    {
      $sql = "SELECT `selected` FROM  $tablename  ";   
      $querymodel = new QueryModel();

      return count($querymodel->queryAction($sql));
  
    }
}
