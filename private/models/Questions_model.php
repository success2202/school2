<?php
//questions model

class Questions_model extends Model
{
    protected $table = "test_questions";
    protected $allowedColumns = [
        'question',
        'date',
        'comment',
        'test_id',
        'question_type',
        'correct_answer',
        'choices',
        'image',
        ];

    protected $beforeInsert = [
        'make_user_id',
        ];

    protected $afterSelect = [
         'get_user',
          ];

   public function validate($DATA){
    $this->errors = array();
    //check for question
    if(empty($DATA['question']))
    {
       $this->errors['question'] = "please add a valid question";
    }

    //check for multiple choice answers
    $num = 0;
    $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
    foreach($DATA as $key => $value){
        if(strstr($key, 'choice')){
            if(empty($value))
            {
                $this->errors['choice'.$num] = "please add a valid answer in choice".$letters[$num];  
            }
            $num++;
        }
    }
    //checking answer if is empty
    if(isset($DATA['correct_answer'])){
        
       if(empty($DATA['correct_answer']))
        {
        $this->errors['correct_answer'] = "please add a valid answer";
        }
    }

     if(count($this->errors) == 0 )
        {
            return true;
        }
        return false;
     }
   
   public function make_user_id($data){
    if(isset($_SESSION['USER']->user_id)){
       $data['user_id'] = $_SESSION['USER']->user_id;  
   }
    return $data;
}



// public function make_school_id($data){
    
//     $data['school_id'] = random_string(60);
//     return $data;

// }


   public function get_user($data){
    $user = new User();
    //checking if user_id exist for total questions
    if(isset($data[0]->user_id)){ 
        foreach($data as $key => $row){
        $result = $user->where('user_id', $row->user_id);
            $data[$key]->user = is_array($result) ? $result[0] : false;
    }
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
