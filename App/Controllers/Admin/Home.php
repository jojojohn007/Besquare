<?php
namespace App\Controllers\Admin;

use App\Models\Admin;

class Home extends Admin{

    public function indexAction()
    {
$data=$this->setEnviornment();

if(!$data){
 $courseContent = 'a:1:{i:0;a:9:{s:5:"Topic";s:26:"Adding three digit numbers";s:5:"Video";s:92:"class5-v1-Adding_three_digit_numbers_with_regrouping_Addition_and_subtraction_Arithmetic.mp4";s:12:"ProblemTopic";s:16:"Add withing 1000";s:4:"unit";s:24:"Addition and subtraction";s:4:"type";s:5:"video";s:6:"lesson";i:1;s:7:"videoId";s:32:"e3b1beefa2f7ddca0023748ebb322b1b";s:11:"lesson-name";s:20:"Multi-digit addition";s:8:"Problems";a:4:{s:8:"Problem1";s:1:"0";s:8:"Problem2";s:1:"0";s:8:"Problem3";s:1:"0";s:8:"Problem4";s:1:"0";}}}';

    $appMaterials = 's:626:"[{"course":"Class-5","unit":["Addition and subtraction"],
        "lesson":["Multi-digit addition"],"topic":["Adding multiple digit number",
        "Adding within 1000"],"video":[{"videoId":"1","unit":"Addition and subtraction",
        "lesson":1,"lesson-name":"Multi-digit addition","topic":"Adding multiple digit number",
        "type":"video"},{"videoId":"2","unit":"Addition and subtraction","lesson":1,
        "lesson-name":"Multi-digit addition","topic":"Adding multiple digit number",
        "type":"video"}],"problem":[{"problemId":"1","unit":"Addition and subtraction",
        "lesson":1,"lesson-name":"Multi-digit addition","topic":"Adding within 1000",
        "type":"problem"}]}]";';

        Admin::insertIntoColumnWhere('appMaterials','ClassName','Class-5');
        Admin::insertIntoColumnWhere('appMaterials','total_levels','5');


 
        Admin::insertIntoColumnWhere('appMaterials','CourseContent',$courseContent,'ClassName','Class-5') ;      
        Admin::insertIntoColumnWhere('appMaterials','appMaterials',$appMaterials,'ClassName','Class-5') ;      


}
        
    }
}