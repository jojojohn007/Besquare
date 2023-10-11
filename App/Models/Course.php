<?php

namespace App\Models;

use Core\Request;
use Core\Model as CoreModel;

class Course extends CoreModel

{
    public static function addCourse($usersfullname,$coursename){
        $querymodel = new QueryModel();
        $sql =    " SELECT   `total_levels` FROM `appMaterials` WHERE  `appMaterials`.`ClassName` = '" . $coursename . "'  ";;
        $data = $querymodel->queryAction($sql);
        vd($data);
        if(!count($data)>=1){
return false;
        }
        

        $tablewith = new User();
        // vd ($tablewith->tableWith($usersfullname, 'selected_courses', $coursename) == 0) ;
        // vd($tablewith->tableWith('appMaterials','ClassName',$coursename));
//if stopping reppeting of adding same course
        if ($tablewith->tableWith($usersfullname, 'selected_courses', $coursename) == 0) {

            $course_details = [
                'course_progress' => 0,
                'answered_cards' => 0,
                'points' => 0,
                'xp' => 0,
                'badges' => 0,
                'videos_watched' => 0,
                'total_levels'=>$data[0]['total_levels']
            ];
                $course_details = serialize($course_details);    
                $insertData = "INSERT INTO " . $usersfullname . " " . " (`selected_courses`,`course_details`, `activities`) VALUES ('$coursename','".  '`' .   $course_details . '`' ."','')";
                $querymodel->queryAction($insertData);
            echo '1';
        } 

    }

    public static function deleteCourseFromDb($id,string $userfullname) :bool {
            $sql = "DELETE  FROM  `$userfullname` WHERE `$userfullname`.`selected_courses` = '" . $id . "'   " ;
            $data  = QueryModel::staticQueryAction($sql);
            
            //delete history

if(is_array($data)){
    echo 'true';
}else {
    echo 'false';
}
            exit();
    }

    public  function saveToCourseDetails(string $type, array $data, string $courseName)
    {
        $data['points'] += 20;
        $data['xp'] += 200;

        if ($type == 'problem') {

            $data['answered_cards']  += 1;
        } else {
            $data['videos_watched']  += 1;
        }

        echo 'saving';

        $data = serialize($data);
        $this->updateCourseDetails(ucfirst($courseName), users('fullname'), $data);
    }
    public static function getCourseArray(array $adminData, string $id)
    {
        foreach ($adminData as $intKey => $coursearray) {
            foreach ($coursearray as $key => $value) {
                if ($value == $id) {
                    return $coursearray;
                }
            }
        }
    }
    //GET FUNCTIONS

    public static function getCourseMaterialsFromAdmin( string $coloumnName ,string $coursename)
    {
        $data = QueryModel::selectFrom('CourseContent', 'appMaterials', 'ClassName', $coursename ?? users('coursename'));
        
        if(count($data)==0){
            return false;
        }
        $data = ((unserialize(trim($data[0]['CourseContent'], '`'))));
        return ($data);
        // $data = unserialize($data[0]['CourseContent']);
    }

    public static function getCourseMaterialsFromUser(string $coloumnName, string $coursename)
    {
        $data = QueryModel::selectFrom('CourseContent', users('fullname'), 'ClassName', users('coursename'));
        $data = ((unserialize(trim($data[0]['CourseContent'], '`'))));
        return ($data);
        // $data = unserialize($data[0]['CourseContent']);

    }

    public function getCourseDetails($coursename, $key = 'all'): array
    {


        $course_details =  $this->getUsersPersonalTableInformation('course_details', 'selected_courses', ucfirst($coursename), users('fullname'));
        $course_details = ((unserialize(trim($course_details[0]['course_details'], '`'))));
        return ($course_details);
    }

    public  function updateCourseDetails($coursename, $userfullname, string $data): void
    {

        $this->updateUsersPersonalTableInformation('course_details', 'selected_courses', ucfirst($coursename), $userfullname, $data);
    }

    public  function getUsersPersonalTableInformation(string $coloumnName, string $where, string $whereWhat, string $userfullname)
    {

        $sql = " SELECT   `$coloumnName` FROM `$userfullname` WHERE  `$userfullname`.`$where` = '" . $whereWhat . "'  ";
        $data  = $this->getData($sql);
        return $data;
    }
    //UPDATE FUNCTIONS

    public function updateUsersPersonalTableInformation(string $coloumnName, string $where, string $whereWhat, string $userfullname,  $data)
    {

        $sql='' ;

        if($data){
            $sql = "UPDATE `" . $userfullname . "` SET  `$coloumnName` = " . "'" . '`' . $data . '`' . "'  WHERE  `$userfullname`.`$where` = '" . $whereWhat . "'  ";

        }else{
            $sql = "UPDATE `" . $userfullname . "` SET  `$coloumnName` = " . "'" . null . "'  WHERE  `$userfullname`.`$where` = '" . $whereWhat . "'  ";

        }
        $data  = $this->setData($sql);
        return $data;
    }
    public  function getUsersPersonalTableInformation2(string $userfullname, array $coloumnName = [], string $where = '', string $whereWhat = '')
    {


        if ($where) {
            $sql = " SELECT   `$coloumnName` FROM `$userfullname` WHERE  `$userfullname`.`$where` = '" . $whereWhat . "'  ";
        } else if (count($coloumnName) > 0) {
            $str = '';
            foreach ($coloumnName as $key => $val) {
                $str.="" .'`'.$val.'` ,';
            }

            $str = trim($str,',"');
            $sql = " SELECT   $str  FROM `$userfullname` ";
        } else {
            $sql = " SELECT   *  FROM `$userfullname` ";
        }

        $data  = $this->getData($sql);
        return $data;
    }
}
