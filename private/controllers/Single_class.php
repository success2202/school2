<?php
//single class controller

class Single_class extends controller
{
    public function index($id = '')
    {
      $errors = array();
      if(!Auth::access('student'))
      {
          $this->redirect('access_denied');
      }
        $classes = new Classes_model();
        $row = $classes->first('class_id', $id);

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['classes', 'classes'];
       
        if($row)
        {
            $crumbs[] = [$row->class,''];
            
        }

        $limit = 3;
        $pager = new Pager($limit);
        $offset = $pager->offset;

            $page_tab = isset($_GET['tab']) ? $_GET['tab'] : 'lecturers';
           
            $lect = new Lecturers_model();
            $results = false;

         
          if($page_tab == 'lecturers'){
            //display lecturer and remove lecturer
            $query = "select * from class_lecturers where class_id = :class_id && disabled = 0 order by id desc limit $limit offset $offset";
            $lecturers = $lect->query($query,['class_id'=>$id]);
            $data['lecturers'] = $lecturers;

          }else
          if($page_tab == 'students'){
            //display students and remove lecturer
            $query = "select * from class_students where class_id = :class_id && disabled = 0  order by id desc limit $limit offset $offset";
            $students = $lect->query($query,['class_id'=>$id]);
            $data['students'] = $students;

          }else
          if($page_tab == 'tests'){
            //display test
            $query = "select * from tests where class_id = :class_id  order by id desc limit $limit offset $offset";
            $tests = $lect->query($query,['class_id'=>$id]);

            $data['tests'] = $tests;

          }


            $data['row']      = $row;
            $data['crumbs']   = $crumbs;
            $data['page_tab'] = $page_tab;
            $data['results']  = $results;
            $data['errors']  = $errors;
            $data['pager']  = $pager;

            $this->view('single-class',$data);

          }
      

    public function lecturersadd($id = '')
      {
          $errors = array();
           if(!Auth::logged_in())
            {
                $this->redirect('login');
            }
              $classes = new Classes_model();
              $row = $classes->first('class_id', $id);
      
              $crumbs[] = ['Dashboard', ''];
              $crumbs[] = ['classes', 'classes'];
             
              if($row)
              {
                  $crumbs[] = [$row->class,''];
                  
              }
                  $page_tab = 'lecturers-add';
                 
                  $lect = new Lecturers_model();
                  $results = false;


                  if(count($_POST) > 0)
                  {
                    if(isset($_POST['search']))
                    { 
                      if(trim($_POST['name']) != ""){ 
                      //find lecturer
                      $user = new User();
                      $name = "%".trim($_POST['name'])."%";
                      $query = "select * from users where (firstname like :fname || lastname like :lname) && rank = 'lecturer' limit 10";
                      $results = $user->query($query, ['fname'=>$name, 'lname'=>$name]);
                    }else{
                      $errors[] = "please type lectueres name";
                    }
        
                  }else
                  if(isset($_POST['selected']))
                    {
                      //add lecturer
                     $query = "select id from class_lecturers where user_id = :user_id && class_id = :class_id limit 1";
                     
                     if(!$check=$lect->query($query,[
                      'user_id' =>$_POST['selected'],
                      'class_id' => $id,
                     ])){
        
                      $arr = array();
                        $arr['user_id'] = $_POST['selected'];
                        $arr['class_id'] = $id;
                        $arr['disabled'] = 0;
                        $arr['date'] = date("Y-m-d H:i:s");
        
                        //$lect = new Lecturers_model();
                        $lect->insert($arr);
                        $this->redirect('single_class/'.$id.'?tab=lecturers');
                    }else{
                      //check if user is active
                      if(isset($check[0]->disabled))
                      {
                        if($check[0]->disabled)
                        {

                          $arr = array();
                          $arr['disabled'] = 0;
                          $lect->update($check[0]->id,$arr);

                          $this->redirect('single_class/'.$id.'?tab=lecturers');

                        }else{
                               $errors[] = "the lectuerer is already added to the class";
    
                        }

                      }else{
                        $errors[] = "the lectuerer is already added to the class";
                      }
                    }
                 }
                  
                }
               $data['row']      = $row;
            $data['crumbs']   = $crumbs;
            $data['page_tab'] = $page_tab;
            $data['results']  = $results;
            $data['errors']  = $errors;
            
            $this->view('single-class',$data);
          }


 public function lecturersremove($id = '')
          {
              $errors = array();
               if(!Auth::logged_in())
                {
                    $this->redirect('login');
                }
                  $classes = new Classes_model();
                  $row = $classes->first('class_id', $id);
          
                  $crumbs[] = ['Dashboard', ''];
                  $crumbs[] = ['classes', 'classes'];
                 
                  if($row)
                  {
                      $crumbs[] = [$row->class,''];
                      
                  }
                      $page_tab = 'lecturers-remove';
                     
                      $lect = new Lecturers_model();
                      $results = false;
    
                      
                      if(count($_POST) > 0)
                      {
                        if(isset($_POST['search']))
                        { 
                          if(trim($_POST['name']) != ""){ 
                          //find lecturer
                          $user = new User();
                          $name = "%".trim($_POST['name'])."%";
                          $query = "select * from users where (firstname like :fname || lastname like :lname) && rank = 'lecturer' limit 10";
                          $results = $user->query($query, ['fname'=>$name, 'lname'=>$name]);
                        }else{
                          $errors[] = "please type lectueres name";
                        }
            
                      }else
                      if(isset($_POST['selected']))
                        {
                          //add lecturer
                         $query = "select id from class_lecturers where user_id = :user_id && class_id = :class_id && disabled = 0 limit 1";    
                      //remove lecturer from the class
                      
                        if($row = $lect->query($query,[
                          'user_id' =>$_POST['selected'],
                          'class_id' => $id,
                         ])){
            
                          $arr = array();
                            $arr['disabled'] = 1;
            
                            $lect->update($row[0]->id,$arr);
                            $this->redirect('single_class/'.$id.'?tab=lecturers');
                        }else{
                          $errors[] = "the lectuerer was nt found in the class";
                        }
                      
                      }
                    }
                   $data['row']      = $row;
                $data['crumbs']   = $crumbs;
                $data['page_tab'] = $page_tab;
                $data['results']  = $results;
                $data['errors']  = $errors;
                
                $this->view('single-class',$data);
              }


public function studentsadd($id = '')
{
    $errors = array();
      if(!Auth::logged_in())
      {
          $this->redirect('login');
      }
        $classes = new Classes_model();
        $row = $classes->first('class_id', $id);

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['classes', 'classes'];
        
        if($row)
        {
            $crumbs[] = [$row->class,''];
            
        }
            $page_tab = 'students-add';
            
            $stdnt = new Students_model();
            $results = false;
  
    if(count($_POST) > 0)
    {
      if(isset($_POST['search']))
      { 
        if(trim($_POST['name']) != ""){ 
        //find student
        $user = new User();
        $name = "%".trim($_POST['name'])."%";
        $query = "select * from users where (firstname like :fname || lastname like :lname) && rank = 'student' limit 10";
        $results = $user->query($query, ['fname'=>$name, 'lname'=>$name]);
      }else{
        $errors[] = "please type students name";
      }
          
      }else
      if(isset($_POST['selected']))
        {
          //add student
          $query = "select disabled,id from class_students where user_id = :user_id && class_id = :class_id limit 1";
          
          if(!$check=$stdnt->query($query,[
          'user_id' =>$_POST['selected'],
          'class_id' => $id,
          ])){

          $arr = array();
            $arr['user_id'] = $_POST['selected'];
            $arr['class_id'] = $id;
            $arr['disabled'] = 0;
            $arr['date'] = date("Y-m-d H:i:s");

            $stdnt->insert($arr);
            $this->redirect('single_class/'.$id.'?tab=students');
            }else{
              //check if student is active
          if(isset($check[0]->disabled))
          {
            if($check[0]->disabled)
            {

              $arr = array();
              $arr['disabled'] = 0;
              $stdnt->update($check[0]->id,$arr);

              $this->redirect('single_class/'.$id.'?tab=students');

        }else{
                $errors[] = "the student is already added to the class";

        }

        }else{
          $errors[] = "the student is already added to the class";
        }
      }
    }
    
  }
      $data['row']      = $row;
  $data['crumbs']   = $crumbs;
  $data['page_tab'] = $page_tab;
  $data['results']  = $results;
  $data['errors']  = $errors;
  
  $this->view('single-class',$data);
}
        

 public function studentsremove($id = '')
    {
        $errors = array();
          if(!Auth::logged_in())
          {
              $this->redirect('login');
          }
            $classes = new Classes_model();
            $row = $classes->first('class_id', $id);
    
            $crumbs[] = ['Dashboard', ''];
            $crumbs[] = ['classes', 'classes'];
            
            if($row)
            {
                $crumbs[] = [$row->class,''];
                
            }
                $page_tab = 'students-remove';
                
                $stdnt = new Students_model();
                $results = false;

      if(count($_POST) > 0)
      {
        if(isset($_POST['search']))
        { 
          if(trim($_POST['name']) != ""){ 
          //find lecturer
          $user = new User();
          $name = "%".trim($_POST['name'])."%";
          $query = "select * from users where (firstname like :fname || lastname like :lname) && rank = 'student' limit 10";
          $results = $user->query($query, ['fname'=>$name, 'lname'=>$name]);
        }else{
          $errors[] = "please type students name";
        }
                    
      }else
      if(isset($_POST['selected']))
        {
          //add lecturer
          $query = "select id from class_students where user_id = :user_id && class_id = :class_id && disabled = 0 limit 10";    
      //remove lecturer from the class
      
        if($row = $stdnt->query($query,[
          'user_id' =>$_POST['selected'],
          'class_id' => $id,
          ])){

          $arr = array();
            $arr['disabled'] = 1;

            $stdnt->update($row[0]->id,$arr);
            $this->redirect('single_class/'.$id.'?tab=students');
        }else{
          $errors[] = "the student was nt found in the class";
        }
      
      }
    }
        $data['row']      = $row;
    $data['crumbs']   = $crumbs;
    $data['page_tab'] = $page_tab;
    $data['results']  = $results;
    $data['errors']  = $errors;
    
    $this->view('single-class',$data);
  }


  public function testadd($id = '')
  {
      $errors = array();
       if(!Auth::logged_in())
        {
            $this->redirect('login');
        }
          $classes = new Classes_model();
          $row = $classes->first('class_id', $id);
  
          $crumbs[] = ['Dashboard', ''];
          $crumbs[] = ['classes', 'classes'];
         
    if($row)
    {
        $crumbs[] = [$row->class,''];
        
    }
        $page_tab = 'tests-add';
        
        $test_class = new Tests_model();
        $results = false;


        if(count($_POST) > 0)
        {
          
        if(isset($_POST['test']))
          {
            
            $arr = array();
            $arr['test'] = $_POST['test'];
            $arr['description']   = $_POST['description'];
            $arr['class_id']      = $id;
            $arr['disabled']      = 1;
            $arr['date']          = date("Y-m-d H:i:s");

              $test_class->insert($arr);
              $this->redirect('single_class/'.$id.'?tab=tests');
                
     }
      
    }
        $data['row']      = $row;
        $data['crumbs']   = $crumbs;
        $data['page_tab'] = $page_tab;
        $data['results']  = $results;
        $data['errors']  = $errors;
        
        $this->view('single-class',$data);
      }

  
public function testedit($id = '', $test_id = '')
      {
          $errors = array();
           if(!Auth::logged_in())
            {
                $this->redirect('login');
            }
              $classes = new Classes_model();
              $tests = new Tests_model();
              $row = $classes->first('class_id', $id);
              $test_row = $tests->first('test_id', $test_id); 
      
              $crumbs[] = ['Dashboard', ''];
              $crumbs[] = ['classes', 'classes'];
             
        if($row)
        {
            $crumbs[] = [$row->class,''];
            
        }
            $page_tab = 'tests-edit';
            
            $test_class = new Tests_model();
            $results = false;
    
    
    if(count($_POST) > 0)
    {
      
    if(isset($_POST['test']))
      {
        
        $arr = array();
        $arr['test']          = $_POST['test'];
        $arr['description']   = $_POST['description'];
        $arr['disabled']      = $_POST['disabled'];
         
    
        $test_class->update($test_row->id,$arr);
        $this->redirect('single_class/'.$id.'/'.$test_id.'?tab=tests');
                    
         }
          
        }
            $data['row']      = $row;
            $data['test_row'] = $test_row;
            $data['crumbs']   = $crumbs;
            $data['page_tab'] = $page_tab; 
            $data['results']  = $results;
            $data['errors']  = $errors;
            
            $this->view('single-class',$data);
          }
    



public function testdelete($id = '', $test_id = '')
{
    $errors = array();
      if(!Auth::logged_in())
      {
          $this->redirect('login');
      }
        $classes = new Classes_model();
        $tests = new Tests_model();
        $row = $classes->first('class_id', $id);
        $test_row = $tests->first('test_id', $test_id); 

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['classes', 'classes'];
        
  if($row)
  {
      $crumbs[] = [$row->class,''];
      
  }
      $page_tab = 'tests-delete';
      
      $test_class = new Tests_model();
      $results = false;

        
  if(count($_POST) > 0)
  {
    
  if(isset($_POST['test']))
    {
      
  
      $test_class->delete($test_row->id);
      $this->redirect('single_class/'.$id.'?tab=tests');
                  
        }
        
      }

        $data['row']      = $row;
        $data['test_row'] = $test_row;
        $data['crumbs']   = $crumbs;
        $data['page_tab'] = $page_tab; 
        $data['results']  = $results;
        $data['errors']  = $errors;
        
        $this->view('single-class',$data);
      }
        
   }


