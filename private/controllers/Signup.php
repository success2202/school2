<?php
//signup controller

class Signup extends controller
{
    function index()
    {
        $errors = array();
        if(count($_POST) > 0)
        {
            $user = new User();

            if($user->validate($_POST)){
                $arr['firstname'] = $_POST['fname'];
                $arr['lastname'] = $_POST['lname'];
                $arr['email'] = $_POST['email'];
                $arr['gender'] = $_POST['gender'];
                $arr['password'] = $_POST['password'];
                $arr['rank'] = $_POST['rank'];
                $arr['date'] = date("Y-m-d H:i:s");
                //$_POST['date'] = date("Y-m-d H:i:s");
                 $user->insert($arr);
                //$user->insert($_POST);
                $this->redirect('login');
            }else{
                //errors
                $errors = $user->errors;
            }
        }
          $this->view('signup', ['errors'=>$errors]);
    }
    
}