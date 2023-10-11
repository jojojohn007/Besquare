<?php

namespace App\Controllers\Student;

use App\Models\Course;
use App\Models\Session;
use App\Models\User;
use Core\Request;
use Core\View;

class StudentNavigation 
{
    protected function before() {
        // session_start();
        // if(!users('email')){
        //     View::redirect('../login');

        // }
    } 
    public function homeAction(): void
    {

        (session_start());
        $useremail = users('email');

        if ($useremail) {
            $course = new Course();
            $data = User::getAll($useremail);
            Session::addToApp($data, 'userdetails');
            $userdetails = users('userdetails');
            $fullname = $userdetails['name'] . '_' . $userdetails['lastname'];
            Session::addToApp(['fullname' => $fullname]);
            $usersCourseData = (User::getCourseData($fullname));
            $course_details = $course->getUsersPersonalTableInformation2(users('fullname'),['course_details','selected_courses']);
/*
$course_detailsn
 */
            foreach ($course_details as $intKey => $course_detail) {
                $data = unserialize(trim($course_detail['course_details'], '`'));
                $course_details[$course_detail['selected_courses']] =  $data ;
                $answered_cards = $data['answered_cards'];
                $video_watched = $data['videos_watched'];

                if($answered_cards + $video_watched != 0){
                    $value = ($data['answered_cards'] + $data['videos_watched']);
                    $value = $value / $data['total_levels'];
                    $percentage = ($value * 100);
                    $course_details[$course_detail['selected_courses']]['course_progress']=$percentage;            

                }
                unset($course_details[$intKey]);
            }







            View::renderTemplate('student/home.html', [
                'userdata' => $userdetails,
                'coursedata' => $usersCourseData,
                'coursedetails'=>$course_details
            ]);
        } else {
            View::redirect('../login');
        }
    }

 
    public  function startCourseAction(Request $request)
    {



        $classname = $request->sanitizedUserData();
        // $adminData = Course::getCourseMaterialsFromAdmin('appMaterials', $classname);
        // vd($adminData);
        // if(!is_array($adminData)){
        //     return '0';
        //     exit();

        // }
        // unset($adminData);

        // $user = new User();
        (session_start());

       return  Course::addCourse(users('fullname'), $classname);
     

        // self::addCourse(users('fullname'),$classname);


    }

    public function progressAction()
    {
        session_start();
        $course = new Course();
        $calendarData =  $course->getUsersPersonalTableInformation('histories', 'email', users('email'), 'users');
        if ($calendarData) {

            if ($calendarData[0]['histories']) {
                $calendarData = ((unserialize(trim($calendarData[0]['histories'], '`'))));
                $json_data = json_encode($calendarData);

                file_put_contents('assets/json/backendData.json',  $json_data);
            } else {
                file_put_contents('assets/json/backendData.json',  '[]');
            }
        }

        View::renderTemplate('student/progress.html');
    }

    // public function before()
    // {
    //     vd(session_status());
    //     if (session_status() === 1) {

    //         $this->logoutAction();
    //     }
    // }

    public function logoutAction()
    {
        session_start();
        session_destroy();
        View::redirect('home');
    }
}
