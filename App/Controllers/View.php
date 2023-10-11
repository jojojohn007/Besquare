<?php
namespace App\Controllers ;
use Core\View as twigRender;
class View extends \Core\Controller {

    public function   viewAction($val,$arg=[]) :void {
    twigRender::renderTemplate($val.'.html',$arg=[]);;
    }

}