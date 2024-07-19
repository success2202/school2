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
       
        $school_id = Auth::getschool_id();
        $data = $user->query("select * from users where school_id = :school_id && rank not in ('student') ", ['school_id'=>$school_id]);
        
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['staff', 'users'];
        
          $this->view('users',[
            'rows'=>$data,
            'crumbs'=>$crumbs
        ]);
    }
    
}


