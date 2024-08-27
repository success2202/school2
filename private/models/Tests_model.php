<?php
//tests model

class Tests_model extends Model
{
    protected $table = "tests";
    protected $allowedColumns = [
        'test',
        'date',
        'description',
        'class_id',
        'disabled',
        ];

    protected $beforeInsert = [
        'make_user_id',
        'make_school_id',
        'make_test_id',
        ];

    protected $afterSelect = [
         'get_user',
         'get_class',
          ];

   public function validate($DATA){
    $this->errors = array();
    //check for school
    if(empty($DATA['test']) || !preg_match('/^[a-z A-Z0-9]+$/', $DATA['test']))
    {
       $this->errors['test'] = "only letters & allowed in test name";
       return false;
    }
        return true;
     }
   
   public function make_user_id($data){
    if(isset($_SESSION['USER']->user_id)){
       $data['user_id'] = $_SESSION['USER']->user_id;  
   }
    return $data;
}

public function make_school_id($data){
    if(isset($_SESSION['USER']->school_id)){
       $data['school_id'] = $_SESSION['USER']->school_id;  
   }
    return $data;
}



// public function make_school_id($data){
    
//     $data['school_id'] = random_string(60);
//     return $data;

// }


   public function make_test_id($data){
    
        $data['test_id'] = random_string(60);
        return $data;
   
   }

   public function get_user($data){
    $user = new User();
    foreach($data as $key => $row){
      $result = $user->where('user_id', $row->user_id);
        $data[$key]->user = is_array($result) ? $result[0] : false;
    }
    
    return $data;

}

public function get_class($data){
    $class = new Classes_model();
    foreach($data as $key => $row){
        if(!empty($row->class_id)){ 
            $result = $class->where('class_id', $row->class_id);
            $data[$key]->class = is_array($result) ? $result[0] : false;
        }
    }
    
    return $data;

}

//getting the test answers
public function get_answered_test($test_id, $user_id){

        $db = new Database();
        $arr = ['test_id'=>$test_id, 'user_id'=>$user_id];
        $res = $db->query("select * from answered_test where test_id = :test_id && user_id = :user_id limit 1", $arr);
        
        if(is_array($res))
        {
            return $res[0];
        }
        return false; 
    }


    public function get_to_mark_count()
    {
       
        $test = new Tests_model();
        if(Auth::access('admin')){ 
           
             $query = "select * from answered_test where test_id IN (select test_id from tests where school_id = :school_id) && submitted = 1 && marked = 0";
             $arr['school_id'] = $school_id;
             $to_mark = $test->query($query,$arr);
   
         }else{
            //$test = new Tests_model();

        $mytable = "class_lecturers";
        $arr['user_id'] = Auth::getUser_id();  

        $query = "select * from answered_test where test_id IN (select test_id from tests where class_id IN (SELECT class_id FROM `class_lecturers` WHERE user_id = :user_id)) && submitted = 1 && marked = 0";
        $to_mark = $test->query($query,$arr);
                 
    }

        return count($to_mark);
    }


}
