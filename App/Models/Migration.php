<?php
namespace App\Models ;
class Migration extends QueryModel{
protected static array $tablequeries = [
'for_user' => 'create table if not exists users (
    id int unsigned primary key auto_increment ,
     name varchar(50) not null,
     email varchar(50) not null,
     lastname varchar(50) not null,
     password varchar(100) not null,
     image varchar(100)  null,
     date datetime  null,
     histories varchar(4090) 
)'

];
    public function __construct()
    {

        foreach (self::$tablequeries as $key => $value) {
          $this->queryEntry($value);
        }
    }

    private string $studentTable = '';
    public function createTable(){
    
    // if(usersdata('name')){
    //     $createTable ='CREATE TABLE IF NOT EXISTS '.usersdata('name').' '.' 
    //     (id int NOT NULL AUTO_INCREMENT 
    //     ,selected_courses VARCHAR(255)
    //     ,course_progress VARCHAR(30)
    //     , total_server_time VARCHAR(30)
    //      ,`answered_cards` VARCHAR(255)
    //      ,points VARCHAR(255)
    //      ,badges VARCHAR(255)
    //       ,scores VARCHAR(255)
    //       ,xp VARCHAR(255)
    //       ,time VARCHAR(255)
    //       ,videoDetailsForCalendar VARCHAR(4096)
    //       ,exercisecompleted VARCHAR(4096)
    //       , videoswatched VARCHAR(255) ,
    //       videoDetail VARCHAR(4096)
    //       ,PRIMARY KEY(id)) ' ;
    //        $this->queryAction($createTable);
            
    // }



    // $this->queryAction($query);
}


}
?>