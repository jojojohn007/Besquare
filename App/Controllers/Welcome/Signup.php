<?php
namespace App\Controllers\Welcome;
use Core\View;
class Signup extends \Core\Controller {
public function indexAction() :void {

    View::renderTemplate('Home/signup.html'
);
    
}    
}

?>