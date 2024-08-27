<?php
//answers model

class Answers_model extends Model
{
    protected $table = "answers";
    protected $allowedColumns = [
        'user_id',
        'question_id',
        'date',
        'answer',
        'answer_mark',
        'answer_comment',
        'test_id',
        ];
// function that remove spaces when student want to answer questions
    protected $beforeInsert = [
        'trim_spaces',
        ];

    protected $afterSelect = [];

   public function validate($DATA)
   {
    $this->errors = array();
     if(count($this->errors) == 0 )
        {
            return true;
        }
        return false;
     }
   
   public function trim_spaces($data){
    foreach($data as $key => $value){
        $data[$key] = trim($value);
    }
   
    return $data;
}



// public function make_school_id($data){
    
//     $data['school_id'] = random_string(60);
//     return $data;

// }


//    public function get_user($data){
//     $user = new User();
//     foreach($data as $key => $row){
//       $result = $user->where('user_id', $row->user_id);
//         $data[$key]->user = is_array($result) ? $result[0] : false;
//     }
    
//     return $data;

// }


}
