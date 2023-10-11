<?php
include '../../../sqlcon_sesSt/sessionSt.php';
include '../../../sqlcon_sesSt/sqlconn.php';


$studentname = $_SESSION['username'];


$spacelessname = str_replace(' ' , '' , $studentname)    ; 

$createTable ='CREATE TABLE IF NOT EXISTS '.$spacelessname.' '.' 
(id int NOT NULL AUTO_INCREMENT 
,selected_courses VARCHAR(255)
,course_progress VARCHAR(30)
, total_server_time VARCHAR(30)
 ,`answered_cards` VARCHAR(255)
 ,points VARCHAR(255)
 ,badges VARCHAR(255)
  ,scores VARCHAR(255)
  ,xp VARCHAR(255)
  ,time VARCHAR(255)
  ,exercisecompleted VARCHAR(255)
  , videoswatched VARCHAR(255) 
  ,PRIMARY KEY(id) ) ' ;
$shootTable =$conn->query($createTable);


$createTable ='CREATE TABLE IF NOT EXISTS '.$spacelessname.'history'.' 
(id int NOT NULL AUTO_INCREMENT
 ,selected_courses VARCHAR(255)
 ,course_progress VARCHAR(30)
 , date VARCHAR(30) 
 ,`answered_cards` VARCHAR(255)
 ,points VARCHAR(255)
 ,badges VARCHAR(255) 
 ,scores VARCHAR(255)
 ,xp VARCHAR(255)
 ,time VARCHAR(255),PRIMARY KEY(id) ) ' ;
 
$shootTable =$conn->query($createTable);






if(isset($_GET['proceed'])){  //insert course details
       $coursename =  $_GET['coursename'];
       $table = "SELECT * FROM  $spacelessname  WHERE   selected_courses = '$coursename' ";   

      $result =($conn->query($table));


        if($result->num_rows<1){
            // insert  whatever course he/she selects ....
    $insertData ="INSERT INTO ".$spacelessname." "." (`selected_courses`, `course_progress`, `total_server_time`, `answered_cards` ,  `points` , `badges` , `scores`, `xp` ,  `time` , `exercisecompleted` ,`videoswatched`) VALUES ('$coursename','0','0','ex:0','0' , '0' ,'0' , '0','0' , '0' ,'0')" ;
    $shootTable =$conn->query($insertData);
    $email = $_SESSION['email'];
        }
 echo json_encode(array(
        'status' => 'succes',
        'title' => '',
        'description' => '',
        'checkifuserexists' =>"",
        'data' => 'loaded',
       'location'=>""
 ));
}
if(isset($_GET['calltype'])){
$calltype=$_GET['calltype'];
switch($calltype){
case 'programme1':
    echo json_encode(array(
        'status' => 'succes',
        'title' => 'video1',
        'description' => 'Adding three digit numbers with regrouping _ Addition and subtraction _ Arithmetic',
        'url' => 'c-5-sec1/'.$calltype.'.php',
        'data' => 'loaded',
       'location'=>'c-5-sec1/'.$calltype.'.php'
    
    ));
    break;
    case 'programme2':
        echo json_encode(array(
            'status' => 'succes',
            'title' => 'video1',
            'description' => 'Adding three digit numbers with regrouping _ Addition and subtraction _ Arithmetic',
            'url' => 'c-5-sec1/'.$calltype.'.php',
            'data' => 'loaded',
           'location'=>'c-5-sec1/'.$calltype.'.php' 
         
        ));
        break ;
        case 'programme3':
            echo json_encode(array(
                'status' => 'succes',
                'title' => 'video1',
                'description' => 'Adding three digit numbers with regrouping _ Addition and subtraction _ Arithmetic',
                'url' => 'c-5-sec1/'.$calltype.'.php',
                'data' => 'loaded',
               'location'=>'c-5-sec1/'.$calltype.'.php'
            
            ));
            break ;
            case 'programme4':
                echo json_encode(array(
                    'status' => 'succes',
                    'title' => 'video1',
                    'description' => 'Adding three digit numbers with regrouping _ Addition and subtraction _ Arithmetic',
                    'url' => 'c-5-sec1/'.$calltype.'.php',
                    'data' => 'loaded',
                   'location'=>'c-5-sec1/'.$calltype.'.php'
                
                ));
                break ;
                case 'programme5':
                    echo json_encode(array(
                        'status' => 'succes',
                        'title' => 'video1',
                        'description' => 'Adding three digit numbers with regrouping _ Addition and subtraction _ Arithmetic',
                        'url' => 'c-5-sec1/'.$calltype.'.php',
                        'data' => 'loaded',
                       'location'=>'c-5-sec1/'.$calltype.'.php'
                    
                    ));
                    break ;
                    case 'programme6':
                        echo json_encode(array(
                            'status' => 'succes',
                            'title' => 'video1',
                            'description' => 'Adding three digit numbers with regrouping _ Addition and subtraction _ Arithmetic',
                            'url' => 'c-5-sec1/'.$calltype.'.php',
                            'data' => 'loaded',
                           'location'=>'c-5-sec1/'.$calltype.'.php'
                        
                        ));
                        break ;

                        case 'programme7':
                            echo json_encode(array(
                                'status' => 'succes',
                                'title' => 'video1',
                                'description' => 'Adding three digit numbers with regrouping _ Addition and subtraction _ Arithmetic',
                                'url' => 'c-5-sec1/'.$calltype.'.php',
                                'data' => 'loaded',
                               'location'=>'c-5-sec1/'.$calltype.'.php'
                            
                            ));
                            break ;


                            case 'programme8':
                                echo json_encode(array(
                                    'status' => 'succes',
                                    'title' => 'video1',
                                    'description' => 'Adding three digit numbers with regrouping _ Addition and subtraction _ Arithmetic',
                                    'url' => 'c-5-sec1/'.$calltype.'.php',
                                    'data' => 'loaded',
                                   'location'=>'c-5-sec1/'.$calltype.'.php'
                                
                                ));
                                break ;

                                case 'programme9':
                                    echo json_encode(array(
                                        'status' => 'succes',
                                        'title' => 'video1',
                                        'description' => 'Adding three digit numbers with regrouping _ Addition and subtraction _ Arithmetic',
                                        'url' => 'c-5-sec1/'.$calltype.'.php',
                                        'data' => 'loaded',
                                       'location'=>'c-5-sec1/'.$calltype.'.php'
                                    
                                    ));
                                    break ;

                                    case 'programme10':
                                        echo json_encode(array(
                                            'status' => 'succes',
                                            'title' => 'video1',
                                            'description' => 'Adding three digit numbers with regrouping _ Addition and subtraction _ Arithmetic',
                                            'url' => 'c-5-sec1/'.$calltype.'.php',
                                            'data' => 'loaded',
                                           'location'=>'c-5-sec1/'.$calltype.'.php'
                                        
                                        ));
                                        break ;








                    case 'deleteaccount':
                        echo json_encode(array(
                            'status' => 'succes',
                            'title' => 'video1',
                            'description' => 'Adding three digit numbers with regrouping _ Addition and subtraction _ Arithmetic',
                            'url' => 'settingsOptions/'.$calltype.'.php',
                            'data' => 'loaded',
                           'location'=>'settingsOptions/'.$calltype.'.php'
                        
                        ));
                        break ;
                          case 'privacycontrols':
                            echo json_encode(array(
                                'status' => 'succes',
                                'title' => 'video1',
                                'description' => 'Adding three digit numbers with regrouping _ Addition and subtraction _ Arithmetic',
                                'url' => 'settingsOptions/'.$calltype.'.php',
                                'data' => 'loaded',
                               'location'=>'settingsOptions/'.$calltype.'.php'
                            
                            ));
                            break ;
                      
} ;
}



// if ($result = $mysqli->query("SHOW TABLES LIKE '".$table."'")) {
//     if($result->num_rows == 1) {
//         echo "Table exists";
//     }
// }
// else {
//     echo "Table does not exist";
// }

if(isset($_GET['checkifuserexists'])){
$table = "SELECT * FROM $spacelessname  ";
   if($result =($conn->query($table))){
    if($result->num_rows>=1){

    echo json_encode(array(
         'checkifuserexists' =>true

));
}else{

    echo json_encode(array('checkifuserexists' =>false));

   }

   }
}



if(isset($_GET['exercisecompleted'])){

    $class = $_GET['coursename'];
    $excompleted= $_GET['exercisecompleted'];

  
    $insertData ='UPDATE '.$spacelessname.' SET exercisecompleted =  "'.$excompleted.'"  WHERE   selected_courses = "'.$class.'"   ' ; //inserting into  exercise done
    $shootTable =$conn->query($insertData);

}

if(isset($_GET['videoswatched'])){


    $class = $_GET['coursename'];
    $videoswatched= $_GET['videoswatched'];
    
    $insertData ='UPDATE '.$spacelessname.' SET videoswatched =  "'.$videoswatched.'"  WHERE   selected_courses = "'.$class.'"   ' ; //inserting into  videos done
    $shootTable =$conn->query($insertData);

}



if(isset($_GET['getcarddata'])){


          // update users point column

    $class = $_GET['coursename'];
//updates course progress by calculating completed class in class5.php
if(isset($_GET['updateprogress'])){
    $progress =  $_GET['updateprogress'] ;
    $insertData ='UPDATE '.$spacelessname.' SET course_progress =  "'.$progress.'"  WHERE   selected_courses = "'.$class.'"   ' ;
    $shootTable =$conn->query($insertData);

}
    //insert selected course into table with user name
$sql = "SELECT * FROM  $spacelessname  WHERE   selected_courses = '$class' ";
$query = $conn->query($sql);
$row = mysqli_fetch_assoc($query);

$table = "SELECT * FROM  $spacelessname ";

   if($result =($conn->query($table))){
    if($result->num_rows>=1){

    echo json_encode(array( 'checkifuserexists' =>true, 
    'completedCards' => $row['answered_cards'],
    'studentname'=> $spacelessname 
  ));
}else{
    echo json_encode(array('checkifuserexists' =>false));
   }

   }
}


// if(isset($_GET['checkforexistinguser'])){



// }



?>