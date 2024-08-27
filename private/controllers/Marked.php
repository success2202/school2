<?php
//marked controller

class Marked extends controller
{
    function index()
    {
        if(!Auth::access('lecturer'))
        {
            $this->redirect('access-denied');
        }
        $tests = new Tests_model();
        $school_id = Auth::getSchool_id();

        if(Auth::access('admin')){ 
            //$data = $tests->findAll();
             $query = "select * from tests where school_id = :school_id order by id desc";
             $arr['school_id'] = $school_id;

             if(isset($_GET['find']))
        {
            $find = '%' . $_GET['find'] . '%';
            $query = "select * from tests where school_id = :school_id && (test like :find ) order by id desc";
            $arr['find'] = $find; 
        }
            $data = $tests->query($query,$arr);
             
         }else{
            //$test = new Tests_model();

            $mytable = "class_lecturers";
          
          $query = "select * from $mytable where user_id = :user_id && disabled = 0";
          
          $arr['user_id'] = Auth::getUser_id();

    if(isset($_GET['find']))
        {
         $find = '%' . $_GET['find'] . '%';
         $query = "select tests.test, {$mytable}.* from $mytable join tests on tests.test_id ={$mytable}.test_id where {$mytable}.user_id = :user_id && {$mytable}.disabled = 0 && tests.test like :find";
         $arr['find'] = $find; 
        }

          $arr['stdnt_classes'] = $tests->query($query,$arr);
         
          //getting the test from the selected classes
          $data = array();
          if($arr['stdnt_classes']){
              foreach ($arr['stdnt_classes'] as $key => $arow) {
                
                $query = "select * from tests where class_id = :class_id";
                $a = $tests->query($query,['class_id'=>$arow->class_id]);
                if(is_array($a)){
                    $data = array_merge($data, $a); //getting the test result and adding it to an array data
                }
              }
          }
    }
     //get all submitted tests
     $marked = array();
     if(count($data) > 0){

        $all_tests = array_column($data, 'test_id');
        $all_tests_string = "'".implode("','", $all_tests)."'";
        
         $query = "select * from answered_test where test_id in ($all_tests_string) && submitted = 1 && marked = 1";
         $marked = $tests->query($query);

         if(is_array($marked)){

            foreach ($marked as $key => $value) {
            $test_details = $tests->first('test_id', $marked[$key]->test_id);
            $marked[$key]->test_details = $test_details;
             //getting the test result and adding/merging it to an array data
         }
       }
   }

    $crumbs[] = ['Dashboard', ''];
    $crumbs[] = ['To_mark', 'to_mark'];
        $this->view('marked',[
        'crumbs'=>$crumbs,
        'test_rows'=>$marked
    ]);
        //show($marked);
        //   $this->view('marked');
    }
    
}


