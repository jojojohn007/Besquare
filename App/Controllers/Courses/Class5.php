<?php

namespace App\Controllers\Courses;

use App\Models\Course;
use App\Models\Session;
use Core\Controller;
use Core\View;

class Class5 extends Controller
{


    public function before()
    {

        vd(session_status());
        if (session_status() === 1) {

            $this->logoutAction();
        }
    }

    public function logoutAction()
    {
        session_start();
        session_destroy();
        View::redirect('home');
    }


    public function homeAction($controller): void
    {
        session_start();

        Session::addToApp(['coursename' => $controller]);
        $data = Course::getCourseMaterialsFromAdmin('appMaterials', users('coursename'));

        $course = new Course();

        $userdata =  $course->getUsersPersonalTableInformation('activities', 'selected_courses', ucfirst($controller), users('fullname'));





        if (($userdata[0]['activities'])) {
            //!=== SNEAKING IN USERS COURSE DETAILS TO ADMINS COURSE DATA FOR CONVINIENCE
            $userdata = unserialize(trim($userdata[0]['activities'], '`'));
            $uniqueIds = array_keys($userdata);

            foreach ($data as $intKey => $coursearray) {
                foreach ($coursearray as $stringKey => $value) {
                    //users data check 
                    foreach ($userdata as $uniqueId => $activityArray) {
                        if ($value == $uniqueId) {
                            $currentCourseArray = $coursearray;
                            ($data[$intKey][$uniqueId] = $activityArray);
                        }
                    }
                }
            }
        } else {
            $userdata = '';
            $uniqueIds = '';
        }

        $course_details = $course->getUsersPersonalTableInformation2(users('fullname'),['course_details','selected_courses']);

        foreach ($course_details as $intKey => $course_detail) {
            $data2 = unserialize(trim($course_detail['course_details'], '`'));
            $course_details[$course_detail['selected_courses']] =  $data2 ;
            $answered_cards = $data2['answered_cards'];
                $video_watched = $data2['videos_watched'];
                if($answered_cards + $video_watched != 0){
                    $course_details[$course_detail['selected_courses']]['course_progress']=  ($data2['answered_cards']+$data2['videos_watched']/$data2['total_levels']) * 100;            

                }
                
    
        }

        $progress = ($course_details[ucfirst($controller)]['course_progress']);

        View::renderTemplate("$controller/index.html", [
            'adminCourseData' => $data,
            'coursename' => ucfirst($controller),
            'uniqueIds' => $uniqueIds,
            'progress'=>$progress
        ]);
    }


    public function  saveUserdetailAction($controller)
    {
        session_start();

        $_POST = json_decode(file_get_contents("php://input"), true);
        $adminData = Course::getCourseMaterialsFromAdmin('appMaterials', ucfirst($controller));

        //first time  ;

        //second time ;

        //saving activity 
        #


        $classMaterial = checkForGenuineID($adminData, 'videoId', $_POST['id']);
        //SAVING ACTIVITY IN DB(FOR COMPARISON IF WATCHED OR NOT )
        if ($classMaterial) {

            $course = new Course();
            $data =  $course->getUsersPersonalTableInformation('activities', 'selected_courses', ucfirst($controller), users('fullname'));
            $course_details = $course->getCourseDetails($controller);


            // $course_details = ser


            //common
            $id = $_POST['id'];
            $type = $_POST['type'];
            //for calendar;
            $saveForCalendar = false;
            $problemId = '';
            $currentCourseArray = Course::getCourseArray($adminData, $id);
    

            //if user has already watched any video
            $todayDate = date("Y-n-j");

            if (($data[0]['activities'])) {


                $data = ((unserialize(trim($data[0]['activities'], '`'))));
                if ($_POST['type'] == 'problem') {


                    $problemId = $_POST['problemId'];
                    $id = $problemId;

                    $array = $data[$id][$type] ?? '';

                    if ($array) {
                        array_push($data[$id][$type], $problemId);
                    } else {
                        ($data[$id][$type][] = $problemId);
                    }
                    $data = serialize($data);
                    $saveForCalendar = true;
                    $course->updateUsersPersonalTableInformation('activities', 'selected_courses', ucfirst($controller), users('fullname'), $data);
                } else {
                    $data[$_POST['id']]['currentTime'] = $_POST['CurrentTime'];
                    $data = serialize($data);
                    $saveForCalendar = true;
                    $course->updateUsersPersonalTableInformation('activities', 'selected_courses', ucfirst($controller), users('fullname'), $data);
                }
            } else {
                $oraganised = [
                    $_POST['id'] => [
                        'currentTime' => round($_POST['CurrentTime'], PHP_ROUND_HALF_UP),
                    ]
                ];
                $saveForCalendar = true;

                $data = serialize($oraganised);
                $course->updateUsersPersonalTableInformation('activities', 'selected_courses', ucfirst($controller), users('fullname'), $data);
            }

            //SAVING ACTIVITY IN DB (FOR SHOWING IT IN CALENDAR);

            if ($saveForCalendar) {




                $data = ((unserialize($data)));
                $course2 = new Course();
                $calendarData =  $course2->getUsersPersonalTableInformation('histories', 'email', users('email'), 'users');

                if ($calendarData[0]['histories']) {
                    $calendarData = ((unserialize(trim($calendarData[0]['histories'], '`'))));
                    foreach ($calendarData as $intKey => $historyArray) {

                        if (key_exists($type, $historyArray)) {
                            $detailsInHistory = $historyArray[$type];
                            foreach ($detailsInHistory as $key => $detail) {
                                if ($detail['id'] == $id) {
                                    exit('Already saved ');
                                } else {
                                    echo 'saving now';
                                    $course->saveToCourseDetails($type, $course_details, $controller);
                                }
                            }
                            $courseDetails =

                                [
                                    "id" => $id,
                                    "unit" => $currentCourseArray['unit'],
                                    "lesson" => $currentCourseArray['lesson'],
                                    "lesson-name" => $currentCourseArray['lesson-name'],
                                    "topic" =>  str_replace('_', ' ', $currentCourseArray['Topic']),
                                    "url" => "Courses/" . ucfirst($controller),
                                    "time" => '1:00pm',
                                    "class" => ucfirst($controller),
                                    "type" => $type
                                ];

                            array_push($calendarData[$intKey][$type], $courseDetails);

                            $data = serialize($calendarData);
                            $json_data = json_encode($calendarData);
                            $course2->updateUsersPersonalTableInformation('histories', 'email', users('email'), 'users', $data);
                        } else {
                            //if user has solved or watched anything today ;





                            if ($historyArray['date'] == $todayDate && $historyArray['course'] == ucfirst($controller)) {


                                $courseDetails = [

                                    [
                                        "id" => $id,
                                        "unit" => $currentCourseArray['unit'],
                                        "lesson" => $currentCourseArray['lesson'],
                                        "lesson-name" => $currentCourseArray['lesson-name'],
                                        "topic" =>  str_replace('_', ' ', $currentCourseArray['Topic']),
                                        "url" => "Courses/" . ucfirst($controller),
                                        "time" => '1:00pm',
                                        "class" => ucfirst($controller),
                                        "type" => $type
                                    ]


                                ];

                                vd($course->saveToCourseDetails($type, $course_details, $controller)
                                );
                                $calendarData[$intKey][$type] = $courseDetails;
                                $data = serialize($calendarData);
                                $json_data = json_encode($calendarData);
                                $course2->updateUsersPersonalTableInformation('histories', 'email', users('email'), 'users', $data);
                            } else {
                            }
                        }
                    }
                }
                //ONE TIME 
                else {

                    $problemKey = $id;

                    if ($type == 'problem') {

                        $problemKey = $problemId;
                    }

                    $course->saveToCourseDetails($type, $course_details, $controller);


                    $courseDetails = [
                        [
                            "date" => $todayDate,
                            "course" => ucfirst($controller),
                            $type => [
                                [
                                    "id" => $problemKey,
                                    "unit" => $currentCourseArray['unit'],
                                    "lesson" => $currentCourseArray['lesson'],
                                    "lesson-name" => $currentCourseArray['lesson-name'],
                                    "topic" =>  str_replace('_', ' ', $currentCourseArray['Topic']),
                                    "url" => "Courses/" . ucfirst($controller),
                                    "time" => '1:00pm',
                                    "class" => ucfirst($controller),
                                    "type" => $type
                                ]
                            ]
                        ]
                    ];
                    $data = serialize($courseDetails);
                    $course2->updateUsersPersonalTableInformation('histories', 'email', users('email'), 'users', $data);
                }
            }
        }
    }
}
