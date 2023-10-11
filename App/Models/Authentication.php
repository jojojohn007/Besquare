<?php
// Performs user logins/logouts
//login signup validation
// Records user login attempts to a database.
// Performs password verifications.
// Reads data about the request (cookies, end use IP address, user agent, etc.).
// Generates tokens/hashes.
// Exposes generalized cookie setting/unsetting functionality.
// Persists authentication status to session.
// Persists authentication status to cookies.
// Loads user data from the database.
namespace App\Models;

use App\Models\QueryModel;

class Authentication extends QueryModel {
    public array $errors = [];

    public function checkUserExist() : bool {
        
        return false;
        
    }
    public function loginUser($data){
        $validatedData = $this->validateSignupDetails($data ,'loginValidation'); 
        $result1 = (count($this->errors)==0)? 'no_errors' :'';
        $result2 =   ($result1)?($this->where($data)):false;
        
        $msg = (!$result2 && !(count($this->errors)==0))?'': '' ;

     if($result2){
        return true;
     }
     
    
    }
    public function addUser($data){

        $createTable ='CREATE TABLE IF NOT EXISTS '.$data['name'].'_'.$data['lastname'].' 
        (id int NOT NULL AUTO_INCREMENT 
        ,selected_courses VARCHAR(255)
        , course_details VARCHAR(4096)
        ,activities VARCHAR(4096)
          ,PRIMARY KEY(id)) ' ;
    

        $validatedData = $this->validateSignupDetails($data); 
        //if errors send errors to user ;
          $result1 = (count($this->errors)==0)? 'no_errors' :('converErrorsToJs( $this->errors)');
          //check if user exist by passing an array with name, : "name" = $post['name];
          $arr['name'] =  $_POST['name'];
          $result2 =   $result1?($this->where($arr)):false;
            // vd($this->queryEntry('SELECT * FROM '.$_POST['name']));
          $result3 = ($result2)?'showMessageToUser(User already exist )':false;
          
          if(!$result3 && $result1=='no_errors'){
              $this->queryEntry($createTable);
              $result4 = ($result3===false && gettype($validatedData) != "boolean")?$this->insert($validatedData):false;

              return true;
          }
          unset($_POST);
            
      }
      
    public function loguser(array $data)  {
      
        $this->checkUserExist($data['name']);
        
    }
 
    public function validateSignupDetails($data ,$validate=[]){
        if(empty($data['name']) && !$validate){
            $this->errors['name']= "Username is empty";
        }elseif( !$validate && !preg_match('/^[a-zA-Z0-9_-]{3,16}$/',$data['name'])){
             $this->errors['name']="Username must be 3-16 characters long and may only contain letters, numbers, underscores, and hyphens";
        }
        
        if(empty($data['password'])){
            $this->errors['password']= "password is empty";
        }else if(!$validate &&  $data['password']!= $data['rptpassword'] ){
            $this->errors['rptpassword']= "Password given dosen't match each other";
       
      }
        if(  empty($data['email'])){
            $this->errors['email']= "email is empty";
        }elseif(!filter_Var($data['email'],FILTER_VALIDATE_EMAIL)){
            $this->errors['email']="invalid email format";
            
        }
       
        unset($data['rptpassword']);
        unset($data['submit']);
       (count($this->errors)>0)?false:true;
               return  (count($this->errors)>0)?false:$data;
    }
    
}