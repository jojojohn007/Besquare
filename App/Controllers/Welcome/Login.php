<?php
namespace App\Controllers\Welcome;
use Core\View;
class Login extends \Core\Controller {
public function indexAction() :void {

    View::renderTemplate('Home/login.html');

}
protected function before() :void {

    
} 


public function loginUserAction(){

    
echo 'hello';

    // View::redirect('signup');
    
}
}

?>