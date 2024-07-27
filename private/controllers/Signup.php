<?php
//signup controller

class Signup extends controller
{
    function index()
    {

        if(!Auth::logged_in())
        {
            $this->redirect('login');
        }

        $mode = isset($_GET['mode']) ? $_GET['mode'] : '';  
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
                if(Auth::access('reception')){
                    if($_POST['rank'] == 'superAdmin' && $_SESSION['USER']->rank != 'superAdmin')
                    {
                        $_POST['rank'] == 'admin';
                    }
                     $user->insert($arr);
                 }
                //$user->insert($_POST);
                $redirect = $mode == 'students' ? 'students' : 'users';   //checking if user is student and add the student to student and if not add to staff
                $this->redirect($redirect);
            }else{
                //errors
                $errors = $user->errors;
            }
        }      
        if(Auth::access('reception')){
            $this->view('signup', [
                'errors'=>$errors,
                'mode'=>$mode
        ]);
    }else{
         $this->view('access-denied');
    }
    }
    
}