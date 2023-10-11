<?php
namespace App\Controllers\Welcome;
use Core\View;
class Contact extends \Core\Controller {
public function indexAction() :void {

    View::renderTemplate('Home/contact.html'
);
    
}    
}

?>