<?php

namespace Core;

use PDO;
use App\Config;

class Model
{
    protected static function getDb()
    {

        static $db =  null;
        if ($db == null) {

            $username = 'root';
            $password = '';
            try {
                $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME . ';charset-utf8';
                $db = new PDO($dsn, $username, $password);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                return $db ?? 'nothing to fetch from data base';
            } catch (\PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
    protected function getData($sql)
    {

     $db =  null;
        if ($db == null) {

            $username = 'root';
            $password = '';
            try {
                $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME . ';charset-utf8';
                $db = new PDO($dsn, $username, $password);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                if (!$db) {
                    return $db ?? 'nothing to fetch from data base';
                }

                try {
                    $stmt = $db->query($sql);
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    return $result;
                } catch (\PDOException $th) {
                    echo $th->getMessage();
                }
            } catch (\PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
    protected function setData($sql,$data=[])
    {

         $db =  null;
        if ($db == null) {

            $username = 'root';
            $password = '';
            try {
                $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME . ';charset-utf8';
                $db = new PDO($dsn, $username, $password);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                if (!$db) {
                    return $db ?? 'nothing to fetch from data base';
                }

                try {
                    $stmt = $db->query($sql);
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                  
                    $stmt= $db->prepare($sql);  
                    $check = $stmt->execute($data);
                    return $check;
                } catch (\PDOException $th) {
                    echo $th->getMessage();
                }
            } catch (\PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
}
