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
    
}


