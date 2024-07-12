<?php
//user model

class User extends Model
{
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
}
