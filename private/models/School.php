<?php
//schools model

class School extends Model
{
    //protected $table = "school";
    protected $allowedColumns = [
        'school',
        'date',
        ];

    protected $beforeInsert = [
        'make_user_id',
        'make_school_id',
        ];

    protected $afterSelect = [
         'get_user',
          ];

   public function validate($DATA){
    $this->errors = array();
    //check for school
    if(empty($DATA['school']) || !preg_match('/^[a-z A-Z]+$/', $DATA['school']))
    {
       $this->errors['school'] = "only letters must be allowed in school";
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
    
        $data['school_id'] = random_string(60);
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


//    private function random_string($length){
//     $array = array(0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
//     $text = "";
//     for($x = 0; $x < $length; $x++){
//         $random = rand(0,61);
//         $text .= $array[$random];
//     }
//     return $text;
//    }

}
