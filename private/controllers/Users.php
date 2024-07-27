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
        
        $query = "select * from users where school_id = :school_id && rank not in ('student') order by id desc";
        $arr['school_id'] = $school_id;

        if(isset($_GET['find']))
        {
            $find = '%' . $_GET['find'] . '%';
            $query = "select * from users where school_id = :school_id && rank not in ('student') && (firstname like :find || lastname like :find) order by id desc";
            $arr['find'] = $find; 
        }
        $data = $user->query($query,$arr);


        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['staff', 'users'];
    if(Auth::access('admin')){ 
            $this->view('users',[
                'rows'=>$data,
                'crumbs'=>$crumbs
        ]);
     }else{
        $this->view('access-denied');
        }
    }
    
}


