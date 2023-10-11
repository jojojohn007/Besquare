<?php 
namespace App\Controllers;
use \Core\View ;
use App\Models\Post as UserPosts;
class Post extends \Core\Controller {
    public function indexAction(){
$post = UserPosts::getAll();
        View::renderTemplate(
            'Posts/index.html',
            [
                'posts' => $post
            ]
        );
    }

    public function addPostAction(){
        echo 'add post';
    }
    
    protected  function before(){
echo  '(BEFORE)';
// echo 'not logged in ';
// return false ;
    }
    protected function after(){
        echo  '(AFTER)';
    }
}