<?php

namespace App\Controllers\Authentication;

use App\Models\Authentication;
use App\Models\Course;
use App\Models\Session;
use Core\Request;
use Core\View;

class UserController extends Authentication
{
    public function loginAction(Request $request): void
    {
        $data = $request->sanitizedUserData();

        if ($this->loginUser($data)) {
            Session::startApp($data);            
            View::redirect('student/home');
        }else {
            View::redirect('login');
        }
    }

    public function signupAction(Request $request)
    {

        $data = ($request->sanitizedUserData());

        if ($this->addUser($data)) {
            View::redirect('login');
        } else {

            echo "signup failed";
        }
    }

    public function deleteCourseAction($id){
        
        (session_start());
        $useremail = users('email');

        if ($useremail) {
            $course = new Course();
            ($course->updateUsersPersonalTableInformation('histories', 'email', users('email'), 'users', null));


            Course::deleteCourseFromDb($id,users('fullname'));
           

        }else{
            throw new \Exception('Method not allowed please login and try again');
        }

    }



}
