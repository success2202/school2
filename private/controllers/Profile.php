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

          // $lect = new Lecturers_model();
          // $data['lect_classes'] = $lect->where('user_id', $id);

          //$stdnt = new Students_model();
          //fetching student that is not disabled
          $query = "select * from $mytable where user_id = :user_id && disabled = 0";
          $data['stdnt_classes'] = $class->query($query,['user_id'=>$id]);
         
          //getting the class the student belong to
          $data['student_classes'] = array();
          if($data['stdnt_classes']){
              foreach ($data['stdnt_classes'] as $key => $arow) {
                $data['student_classes'][] = $class->first('class_id', $arow->class_id);
              }
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


