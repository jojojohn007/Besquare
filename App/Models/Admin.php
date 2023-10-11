<?php
namespace App\Models;

class Admin {

    public  function setEnviornment(){

        $query = new QueryModel;
        
        $sql = 'create table if not exists appMaterials (
            id int unsigned primary key auto_increment ,
             ClassName varchar(10) ,
             CourseContent varchar(4000),
             UnitTest varchar(2048) ,
             LastWatchTime varchar(100) ,
             CourseMaterial varchar(4000),
             appMaterials varchar(4000),
             total_levels varchar(2)
        )';

         $query->queryAction($sql);
        $sql = 'SELECT * FROM appMaterials';
        $data = $query->queryAction($sql);

        return $data;



    }

    public static function insertIntoColumnWhere(
        string $tableName ,
        string $coloumnName,
        string $serializedData,
        string $whereColoumn='',
        string | int $wheredata =''
        ) :array | bool {

        $query = new QueryModel;
        vd($whereColoumn,$wheredata);
        if($whereColoumn || $wheredata){

            // $sql = "INSERT INTO `$tableName` (`$coloumnName`)
            // VALUES ('$serializedData') WHERE '$whereColumn' = '$wheredata' ";

        $sql = "UPDATE  appMaterials SET  $coloumnName = " . "'" . '`' . $serializedData . '`' . "'  WHERE $whereColoumn = '$wheredata'";

            vd($sql);

            $result = $query->queryAction($sql);
       
        }{

            $sql = ("INSERT INTO `$tableName` (`$coloumnName`) VALUES ('$serializedData') ");
            vd($sql);

    $result = $query->queryAction($sql);

        }

        return $result;


    }

}