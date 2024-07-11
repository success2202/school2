<?php
//home controller

class Home extends controller
{
    function index()
    {
        //$db = new Database();
        //$user = $this->load_model('user');
        $user = new User();
        //$arr['firstname'] = 'Eto B';
        //$arr["lastname"] = 'onyedikachi';
        //$arr ["date"] = '2024-07-03 16:39:25';
        //$arr["user_id"] = '33';
        //$arr["gender"] = 'male';
        //$arr["school_id"] = 'sch001';
        //$arr["rank"] = 'student';
        //$user->insert($arr); 
        //$user->update(6,$arr); 
        //$user->delete(6); 
        $data = $user->findAll();
          $this->view('home',['rows'=>$data]);
    }
    
}


