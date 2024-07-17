<?php
//users controller

class Users extends controller
{
    function index()
    {
        if(!Auth::logged_in())
        {
            $this->redirect('login');
        }
        $user = new User();
       
        $data = $user->findAll();
          $this->view('users',['rows'=>$data]);
    }
    
}


