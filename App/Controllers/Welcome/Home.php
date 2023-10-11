<?php
namespace App\Controllers\Welcome;
use Core\View;
class Home extends \Core\Controller {
public function indexAction() :void {

    View::renderTemplate('Home/index.html',
[
    'name'=>PUBROOT
]
);
    
}    
}

?>