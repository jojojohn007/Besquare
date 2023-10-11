<?php
namespace App\Controllers\Welcome;
use Core\View;
class About extends \Core\Controller {
public function indexAction() :void {

    View::renderTemplate('Home/about.html'
);
    
}    
}

?>