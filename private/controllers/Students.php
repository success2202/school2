<?php
//students  controller

class Students extends controller
{
    function index()
    {
        if(!Auth::logged_in())
        {
            $this->redirect('login');
        }
        $user = new User();
       
        $school_id = Auth::getschool_id();
        $data = $user->query("select * from users where school_id = :school_id && rank in ('student')", ['school_id'=>$school_id]);
        
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['students', 'students'];
        
          $this->view('students',[
            'rows'=>$data,
            'crumbs'=>$crumbs
        ]);
    }
    
}


