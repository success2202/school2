<?php
//user model

class User extends Model
{
    protected $allowedColumns = [
        'firstname',
        'lastname',
        'email',
        'password',
        'gender',
        'date',
        'rank',];

    protected $beforeInsert = [
        'make_user_id',
        'make_school_id',
        'hash_password'];

   public function validate($DATA){
    $this->errors = array();
    //check for firstname
    if(empty($DATA['fname']) || !preg_match('/^[a-zA-Z]+$/', $DATA['fname'])){
        $this->errors['fname'] = "the first name must be letters";
    }
    //check for last name
    if(empty($DATA['lname']) || !preg_match('/^[a-zA-Z]+$/', $DATA['lname'])){
        $this->errors['lname'] = "the last name must be letters";
    }
    //check for email
    if(empty($DATA['email']) || !filter_var($DATA['email'],FILTER_VALIDATE_EMAIL)){
        $this->errors['email'] = "invalid email";
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

   public function make_user_id($data){
    $data['user_id'] = $this->random_string(60);
        return $data;
   }

   public function make_school_id($data){
    if(isset($_SESSION['USER']->school_id)){
        $data['school_id'] = $_SESSION['USER']->school_id;
    }
        return $data;
   }

   public function hash_password($data){
    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $data;
   }

   public function random_string($length){
    $array = array(0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
    $text = "";
    for($x = 0; $x < $length; $x++){
        $random = rand(0,61);
        $text .= $array[$random];
    }
   }
}
