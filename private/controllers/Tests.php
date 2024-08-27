<?php
//Test controller

class Tests extends controller
{
    public function index()
    {
        if(!Auth::logged_in())
        {
            $this->redirect('login');
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
            $disabled = "disabled = 0 &&";
            $mytable = "class_students";
          if(Auth::getRank() == 'lecturer'){
            $mytable = "class_lecturers";
            $disabled = "";
          }

          $query = "select * from $mytable where user_id = :user_id && disabled = 0 ";
          
          $arr['user_id'] = Auth::getUser_id();
          $arr['stdnt_classes'] = $tests->query($query,$arr);
         
          //getting the test 
          $data = array();
          $arr2 = array();
          if($arr['stdnt_classes']){
              foreach ($arr['stdnt_classes'] as $key => $arow) {
                $a = $tests->where('class_id', $arow->class_id);
                $query = "select * from tests where $disabled class_id = :class_id";
                $arr2['class_id'] = $arow->class_id;
                if(isset($_GET['find']))
                {
                 $find = '%' . $_GET['find'] . '%';
                 $query = "select * from tests where $disabled class_id = :class_id && test like :find";
                 //$query = "select tests.test, {$mytable}.* from $mytable join tests on tests.test_id ={$mytable}.test_id where {$mytable}.user_id = :user_id && {$mytable}.disabled = 0 && tests.test like :find";
                 $arr2['find'] = $find; 
                }

                $a = $tests->query($query,$arr2);
                if(is_array($a)){
                    $data = array_merge($data, $a); //getting the test result and adding it to an array data
                }
              }
          }
         }
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['tests', 'tests'];
          $this->view('tests',[
            'crumbs'=>$crumbs,
            'test_rows'=>$data
        ]);
    }
    
    //add school
    public function add()
    {
        if(!Auth::logged_in())
        {
            $this->redirect('login');

        }
        $errors = array();
        if(count($_POST) > 0)
        {
        $tests = new tests_model();
        if($tests->validate($_POST)){
    
            $tests->insert($_POST);
            $this->redirect('tests');
        }else{
            //errors
            $errors = $tests->errors;
        }

        }

             $crumbs[] = ['Dashboard', ''];
             $crumbs[] = ['tests', 'tests'];
             $crumbs[] = ['add', 'tests/add'];
          $this->view('tests.add',[
            'errors'=>$errors,
            'crumbs'=>$crumbs,
            ]);
    }

//edit school
    public function edit($id =null)
    {
        if(!Auth::logged_in())
        {
            $this->redirect('login');
        }

        $tests = new tests_model();
        $errors = array(); //edit test if you add the test and if you are authorised to 
        if(count($_POST) > 0 && Auth::access('lecturer') && Auth::i_own_content($row))
        {
        
        if($tests->validate($_POST)){

            //$arr['school'] = $_POST['school'];
            
            $tests->update($id,$_POST);
            $this->redirect('tests');
        }else{
            //errors
            $errors = $tests->errors;
        }

        }
        $row = $tests->where('id', $id);
       

             $crumbs[] = ['Dashboard', ''];
             $crumbs[] = ['tests', 'tests'];
             $crumbs[] = ['edit', 'tests/edit'];
        //deny access if you are not alloe to edit
        if(Auth::access('lecturer') && Auth::i_own_content($row)){ 
            $this->view('tests.edit',[
                'row'=>$row,
                'errors'=>$errors,
                'crumbs'=>$crumbs,
                ]);
            }else{
                $this->view('access-denied');
            }
        }


//delete school
    public function delete($id = null)
    {
        if(!Auth::logged_in())
        {
            $this->redirect('login');
        }

            $tests = new tests_model();

            $errors = array();
        //delete test if you add the test and if you are authorised to 
         if(count($_POST) > 0 && Auth::access('lecturer') && Auth::i_own_content($row))
            {
                $tests->delete($id);
                $this->redirect('tests');

            }

            $row = $tests->where('id',$id);

                $crumbs[] = ['Dashboard', ''];
                $crumbs[] = ['tests', 'tests'];
                $crumbs[] = ['delete', 'tests/delete'];
                //deny access if you are not allowed to delete
        if(Auth::access('lecturer') && Auth::i_own_content($row)){ 
            $this->view('tests.delete',[
                'row'=>$row,
                'crumbs'=>$crumbs,
                ]);
        }else{
            $this->view('access-denied');
        }
    }
}


