<?php
//signup controller

class Signup extends controller
{
    function index()
    {
        $errors = array();
        if(count($_POST)>0){
            $user = new user();
            if($user->validate($_POST)){
                $this->redirect('login');
            }else{
                //errors
                $errors = $user-errors;
            }
        }
          $this->view('signup', ['errors=>$errors']);
    }
    
}