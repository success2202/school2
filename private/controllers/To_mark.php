<?php
//to_mark controller

class To_mark extends controller
{
    function index()
    {
        if(!Auth::access('lecturer'))
        {
            $this->redirect('access-denied');
        }

        $tests_model = new Tests_model();
        $school_id = Auth::getSchool_id();

        if(Auth::access('admin')){ 
            //$data = $tests->findAll();
             //$query = "select * from tests where school_id = :school_id order by id desc";
             $query = "select * from answered_test where test_id IN (select test_id from tests where school_id = :school_id) && submitted = 1 && marked = 0 order by id desc";
             $arr['school_id'] = $school_id;

    if(isset($_GET['find']))
        {
            $find = '%' . $_GET['find'] . '%';
            $query = "select * from tests where school_id = :school_id && (test like :find ) order by id desc";
            $arr['find'] = $find; 
        }
            $to_mark = $tests_model->query($query,$arr);
             
         }else{
            //$test = new Tests_model();

        $mytable = "class_lecturers";
        $arr['user_id'] = Auth::getUser_id();  

        $query = "select * from answered_test where test_id IN (select test_id from tests where class_id IN (SELECT class_id FROM `class_lecturers` WHERE user_id = :user_id)) && submitted = 1 && marked = 0 order by id desc";
        $to_mark = $tests_model->query($query,$arr);
          
          
        /*
            if(isset($_GET['find']))
                {
                $find = '%' . $_GET['find'] . '%';
                $query = "select tests.test, {$mytable}.* from $mytable join tests on tests.test_id ={$mytable}.test_id where {$mytable}.user_id = :user_id && {$mytable}.disabled = 0 && tests.test like :find";
                $arr['find'] = $find; 
                }
        */
                   
    }

   if($to_mark){
    // get test row data
    foreach($to_mark as $key => $value){
        $a = $tests_model->first('test_id', $value->test_id);
        if($a){
            $to_mark[$key]->test_details = $a;
        }
    }
   }

    $crumbs[] = ['Dashboard', ''];
    $crumbs[] = ['To Mark', 'to-mark'];
        $this->view('to-mark',[
        'crumbs'=>$crumbs,
        'test_rows'=>$to_mark
    ]);
        
          
    }
    
}


