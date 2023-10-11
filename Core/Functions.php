<?php

use function PHPSTORM_META\elementType;

function vd(...$st){
    foreach($st as $st) {
        echo '<pre>';
        var_dump($st);
        echo '</pre>';

    }
    
}

function pr($st) : void {
echo '<pre>';
(print_r($st));
    echo '</pre>';
        
}


function addglobal(\Twig\Environment $twig, array $globals): void
{
  foreach ($globals as $key => $value) {
    $twig->addGlobal($key, $value);
  }
}



function users(string $session_key):array|string|bool{
  if(!isset($_SESSION)){
    return false;
  }
if(key_exists($session_key,$_SESSION)){
  return $_SESSION[$session_key];
}{
 return false; 
}
}

function returnArrayWith($array,$key,$checkfor){

  return  array_filter($array, function($element) use ($checkfor,$key) {
    
    if($element[$key] ==$checkfor ){
      $filteredArray = ($element);
      vd($element);
      return $element[$key];
    }
    });
    
}

function checkForGenuineID(array $data ,string $arraykey ,string $id) :array {
  foreach ($data as $key => $value) {
      foreach ($value as $key2 => $value2) {
          if($key2==$arraykey && $value2 ==$id ){
  return $value;
          }else {
            false;
          }
  
      }
  }
}
