<?php
namespace App\Controllers\Admin ;
use \Core\View;
class User extends \Core\Controller {
    public function indexAction(){
        $data = [
            'name'=>'admin'
        ];
        View::renderTemplate('Admin/index.html',$data);
    }
}