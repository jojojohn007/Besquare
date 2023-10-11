<?php 
namespace App\Models ;

use PDO ;

class Post extends \Core\Model {


    public static function getAll() {

            
        try {
            $db = static::getDb();
            $stmt = $db->query('SELECT id ,title,content FROM posts ORDER BY created_at');
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $th) {
            echo $th->getMessage();
        }


        
    }

}