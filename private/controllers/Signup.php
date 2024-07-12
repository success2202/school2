<?php
//signup controller

class Signup extends controller
{
    function index()
    {
        $errors = array();
        if(count($_POST) > 0){
            $user = new user();
            if($user->validate($_POST)){
                $arr['firstname'] = $_POST['fname'];
                $arr['lastname'] = $_POST['lname'];
               
                $arr['gender'] = $_POST['gender'];
                $arr['rank'] = $_POST['rank'];
                $arr['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $arr['date'] = date('Y-m-d H:i:s');
                $user->insert($arr);
                $this->redirect('login');
            }else{
                //errors
                $errors = $user->errors;
            }
        }
          $this->view('signup', ['errors'=>$errors]);
    }
    
}