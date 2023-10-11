<?php
namespace App\Models;
use Core\Database;
use Core\Model;
use PDO ;

 class QueryModel extends Model  {
use Database ;
    protected $limit =  10;
    protected $offset = 0;
    protected $order = 'DESC';
    protected $table = 'users';






    public static function selectFrom(string $coloumnname,string $tablename ,string $where ,string $wherewhat){
    $sql = " SELECT   `$coloumnname` FROM `$tablename` WHERE $where = '$wherewhat'";
      return     static::staticQueryAction($sql);


  }


   public static function staticQueryAction($sql) {

            
        try {
            $db = static::getDb();
            $stmt = $db->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $th) {
            echo $th->getMessage();
        }


        
    }





    public  function selectFrom2(string $sql){
      return $this->queryAction($sql);
        // return    $data = static::staticQueryAction($sql);
  
  
    }


    //=================OLDER STUFFS ================//
  
    protected $allowed_columns =[

    'image',
    'name',
    'email',
    'lastname',
    'image',
    'password',
    'date'
];

    protected  function queryEntry(string $query){
        return $this->queryAction($query);
    }
  
  
    private function checkForAllowedColmns($data)
    {
  
      $result = !empty($this->allowed_columns) ? true : '';
      $array = $data;
  
      $unassignedKeys = array();
      $array = array(
        "name" => ""
      );
  
      $unassignedKeys = array();
  
      foreach ($array as $key => $value) {
        if (empty($value)) {
          $unassignedKeys[] = $key;
        }
      }
  
      if (empty($unassignedKeys)) {
  
        if ($result) {
  
          foreach ($data as $key => $value) {
            if (!in_array(haystack: $this->allowed_columns, needle: $key)) {
              unset($data[$key]);
              exit();
              return false;
            }
          }
        }
      } else {
        return false;
      }
    }

    
  public function insert($data)
  {
    // $this->checkForAllowedColmns($data);
    $keys = array_keys($data);
    $query = "INSERT INTO $this->table ( " . implode(',', $keys) . ") VALUES (:" . implode(',:', $keys) . ')';

    return  $this->queryAction($query, $data);
  }
  
  
 
  
  
  
    public function where($data, $not_data = [])
    {

  
      //if user try to acess  column that is not included in allowed columns  .return false and unset whatevere user asked for 
  
      $this->checkForAllowedColmns($data);
  
      $object = array_keys($data);
      $Keys_not = array_keys($not_data);
      $query = "SELECT * FROM $this->table WHERE ";
  
      foreach ($object as $key) {
        $query .= $key . " = :" . $key . " && ";
      }
  
      foreach (array_keys($not_data) as $key) {
        $query .= $key . ' != :' . $key . ' && ';
      }
  
      $query = trim($query, " && ");
      $query .= " limit $this->limit offset $this->offset";
  
      $data = array_merge($data, array_keys($not_data));
  
      return $this->queryAction($query, $data);
    }
  
    //READ SINGLE DATA
  

 
    public function getTableRowCount(string $tablename ,string $classname):int
    {
      $table = "SELECT `$classname` FROM  $tablename  ";   
      return count($this->queryAction($table));
  
    }
    public function addCourse(string $username,$coursename): void
    {
      if(($this->getTableRowCount($username,$coursename))==0){
        $insertData ="INSERT INTO ".$username." "." (`selected_courses`, `course_progress`, `total_server_time`, `answered_cards` ,  `points` , `badges` , `scores`, `xp` ,  `time` , `exercisecompleted` ) VALUES ('$coursename','0','0','ex:0','0' , '0' ,'0' , '0','0' , '' )" ;
        $this->queryAction($insertData);
      };
    }
    public function getCourseTableData(string $tablename):array
    {
      $table = "SELECT * FROM  $tablename  "; 
      return ($this->queryAction($table));
  
    }
    public static function getCourseData()
    {
        $sql = 'SELECT * FROM appMaterials ';
      return self::queryAction($sql);
    }
    


}