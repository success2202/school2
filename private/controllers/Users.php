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
       $limit = 3;
       $pager = new Pager($limit);
       $offset = $pager->offset;
       $school_id = Auth::getschool_id();
        
        $query = "select * from users where school_id = :school_id && rank not in ('student') order by id desc limit $limit offset $offset";
        $arr['school_id'] = $school_id;

        if(isset($_GET['find']))
        {
            $find = '%' . $_GET['find'] . '%';
            $query = "select * from users where school_id = :school_id && rank not in ('student') && (firstname like :find || lastname like :find) order by id desc limit $limit offset $offset";
            $arr['find'] = $find; 
        }
        $data = $user->query($query,$arr);


        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['staff', 'users'];
    if(Auth::access('admin')){ 
            $this->view('users',[
                'rows'=>$data,
                'crumbs'=>$crumbs,
                'pager'=>$pager
        ]);
     }else{
        $this->view('access-denied');
        }
    }
    
}


