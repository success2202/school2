<?php
//user model

class User extends Model
{
    //protected $table = "users";
    protected $allowedColumns=[
        'firstname',
        'lastname',
        'email',
        'password',
        'gender',
        'date',
        'rank',
        'school_id',
        'image',];

    protected $beforeInsert = [
        'make_user_id',
        'make_school_id',
        'hash_password',];

    protected $beforeUpdate = [
        'hash_password'
        ];

   public function validate($DATA, $id=''){
    $this->errors = array();
    //check for firstname
    if(empty($DATA['fname']) || !preg_match('/^[a-z A-Z]+$/', $DATA['fname'])){
        $this->errors['fname'] = "the  name must be letters";
    }
        
    //check for last name
    if(empty($DATA['lname']) || !preg_match('/^[a-z A-Z]+$/', $DATA['lname'])){
        $this->errors['lname'] = "the lastname must be letters";
    }
    //check for email
    if(empty($DATA['email']) || !filter_var($DATA['email'],FILTER_VALIDATE_EMAIL)){
        $this->errors['email'] = "invalid email";
    }

    //check if email exist
    if(trim($id)==""){ 
    if($this->where('email', $DATA['email']))
        {
            $this->errors['email'] = "the email is already taken";
        }     
    } else{
        if($this->query("select email from $this->table where email = :email && user_id != :id",['email'=> $DATA['email'], 'id'=>$id]))
        {
            $this->errors['email'] = "the email is already taken";
        }     
    }  
    
     //check for gender
     $genders = ['male', 'female'];
     if(empty($DATA['gender']) || !in_array($DATA['gender'], $genders)){
        $this->errors['gender'] = "invalid gender";
    }
     //check for rank
     $ranks = ['student', 'reception', 'lecturer', 'admin', 'superAdmin'];
     if(empty($DATA['rank']) || !in_array($DATA['rank'], $ranks)){
        $this->errors['rank'] = "please select valid rank";
    }
    //check for password
    if(isset($DATA['password'])){ 
            if(empty($DATA['password']) || $DATA['password'] != $DATA['password2']){
                $this->errors['password'] = "the password do not match";
            }
            //check for password lenght
            if(strlen($DATA['password']) < 8){
                $this->errors['password'] = "password must be at least 8 characters long";
            }
            if(count($this->errors) == 0){
                return true;
            }
            return false;
        }
    }

   public function make_user_id($data){
    //$data['user_id'] = random_string(60);
    //$data['user_id'] = random_st(20);
    $data['user_id'] = strtolower($data['firstname'] . "." . $data['lastname']);
     while($this->where('user_id', $data['user_id']))
    {
        $data['user_id'] .= rand(10,9999);
    }
        return $data;
   }


   public function make_school_id($data){
    if(isset($_SESSION['USER']->school_id)){
        $data['school_id'] = $_SESSION['USER']->school_id;
    }
        return $data;
   }

   public function hash_password($data){
    if(isset($data['password'])){
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
           
     }
     return $data;
     
    }
    
}
