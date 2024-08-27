<?php
//profile controller

class Profile extends controller
{
    function index($id = '')
    {
      if(!Auth::logged_in())
      {
          $this->redirect('login');
      }

        $user = new User(); //getting user id on the prrofile
      $id = trim($id == '') ? Auth::getUser_id() : $id;
        $row = $user->first('user_id', $id);

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['profile', 'profile'];
        if($row)
        {
            $crumbs[] = [$row->firstname,'profile'];
        }
        // get more info depending on the tab
        $data['page_tab'] = isset($_GET['tab']) ? $_GET['tab'] : 'info';
        
        //fetching from class_students table and class_lecturers table in the tab
        if($data['page_tab'] == 'classes' && $row)
        {
          $class = new Classes_model();
          $mytable = "class_students";
          if($row->rank == 'lecturer'){
            $mytable = "class_lecturers";
          }

         
          $query = "select * from $mytable where user_id = :user_id && disabled = 0";
          $data['stdnt_classes'] = $class->query($query,['user_id'=>$id]);
         
          //getting the class the student belong to
          $data['student_classes'] = array();
          if($data['stdnt_classes']){
              foreach ($data['stdnt_classes'] as $key => $arow) {
                $data['student_classes'][] = $class->first('class_id', $arow->class_id);
              }
          }

        }else

          if($data['page_tab'] == 'tests' && $row)
          {
            if($row->rank != 'student'){

              $class = new Classes_model();

              $disabled = "disabled = 0 &&";
              $mytable = "class_students";
              if($row->rank == 'lecturer'){
                $mytable = "class_lecturers";
                $disabled = "";
              }

         
          $query = "select * from $mytable where user_id = :user_id && disabled = 0";
          $data['stdnt_classes'] = $class->query($query,['user_id'=>$id]);
         
          //getting the class the student belong to
          $data['student_classes'] = array();
          if($data['stdnt_classes']){
              foreach ($data['stdnt_classes'] as $key => $arow) {
                $data['student_classes'][] = $class->first('class_id', $arow->class_id);
              }
          }
          $class_ids =[];
          foreach($data['student_classes'] as $key => $class_row){
            $class_ids[] = $class_row->class_id;
          }
          //converting an array into a string
          $id_str = "'" . implode("','", $class_ids) . "'";
          $query = "select * from tests where $disabled class_id in ($id_str)";
          $tests_model = new Tests_model();
          $tests = $tests_model->query($query);
          $data['test_rows'] = $tests;

          }else{  

          //get all submitted tests
            $marked = array();
            $tests = new Tests_model();
                $query = "select * from answered_test where user_id = :user_id && submitted = 1 && marked = 1";
                $answered_tests = $tests->query($query,['user_id'=>$id]);
                
                if(is_array($answered_tests)){
                  
                  foreach($answered_tests as $key => $value){ 
                    $test_details = $tests->first('test_id', $answered_tests[$key]->test_id);
                    $answered_tests[$key]->test_details = $test_details;
                    //getting the test result and adding/merging it to an array data
                }
          }
          $data['test_rows'] = $answered_tests;  
        }  
    }
    
        $data['row'] =$row;
        $data['crumbs'] =$crumbs;

        if(Auth::access('reception') || Auth::i_own_content($row)){
          $this->view('profile',$data);
        }else{
          $this->view('access-denied');
        }
          
    }


    function edit($id = '')
    {
      if(!Auth::logged_in())
      {
          $this->redirect('login');
      }
        $errors = array();
        $user = new User(); //getting user id on the prrofile
        $id = trim($id == '') ? Auth::getUser_id() : $id;
// show($_FILES); die;
        if(count($_POST) > 0 && Auth::access('reception'))
      {

        // check if password exist
        if(trim($_POST['password']) == "")
        {
          unset($_POST['password']);
          unset($_POST['password2']);
        }

        if($user->validate($_POST, $id)){
         // check for files
       if($myimage = upload_image($_FILES))
       {
        $_POST['image'] = $myimage;
       }

        //  if(count($_FILES) > 0 )
        //  {
        //   //we have an immage 
        //   $allowed[] = "image/jpg";
        //   $allowed[] = "image/png"; 
        //   $allowed[] = "image/jpeg";
        //   $allowed[] = "image/gif";

        //   if($_FILES['image']['error'] == 0 && in_array($_FILES['image']['type'], $allowed))
        //   {
        //     $folder = "uploads/";
        //     if(!file_exists($folder)){
        //       mkdir($folder, 0777, true);
        //     }
        //     $destination = $folder . $_FILES['image']['name'];
        //     move_uploaded_file($_FILES['image']['tmp_name'], $destination);
        //     $_POST['image'] = $destination;
        //   }
        //  }
         
           if($_POST['rank'] == 'superAdmin' && $_SESSION['USER']->rank != 'superAdmin')
              {
                  $_POST['rank'] == 'admin';
              }

             $myrow = $user->first('user_id', $id);
              if(is_object($myrow)){
                $user->update($myrow->id, $_POST);
              }
               
          $redirect = 'profile/'.$id;   //redirect to profile 
          $this->redirect($redirect);
      }else{
          //errors
          $errors = $user->errors;
      }
      }

        $row = $user->first('user_id', $id);
        $data['row'] =$row;
        $data['errors'] =$errors;
        
        if(Auth::access('reception') || Auth::i_own_content($row)){
          $this->view('profile-edit',$data);
        }else{
          $this->view('access-denied');
        }
        
       
      }
}


