<?php
//classes controller

class Classes extends controller
{
    public function index()
    {
        if(!Auth::logged_in())
        {
            $this->redirect('login');
        }
        $classes = new classes_model();
        $school_id = Auth::getSchool_id();

        if(Auth::access('admin')){ 
            //$data = $classes->findAll();
             $query = "select * from classes where school_id = :school_id order by id desc";
             $arr['school_id'] = $school_id;

             if(isset($_GET['find']))
        {
            $find = '%' . $_GET['find'] . '%';
            $query = "select * from classes where school_id = :school_id && (class like :find ) order by id desc";
            $arr['find'] = $find; 
        }
            $data = $classes->query($query,$arr);

             
         }else{
            $class = new Classes_model();
          $mytable = "class_students";
          if(Auth::getRank() == 'lecturer'){
            $mytable = "class_lecturers";
          }

          $query = "select * from $mytable where user_id = :user_id && disabled = 0";
          
          $arr['user_id'] = Auth::getUser_id();

    if(isset($_GET['find']))
        {
         $find = '%' . $_GET['find'] . '%';
         $query = "select classes.class, {$mytable}.* from $mytable join classes on classes.class_id ={$mytable}.class_id where {$mytable}.user_id = :user_id && {$mytable}.disabled = 0 && classes.class like :find";
         $arr['find'] = $find; 
        }

          $arr['stdnt_classes'] = $class->query($query,$arr);
         
          //getting the class ids from classes that dont already have members
          $classes_i_own = $class->where('user_id',Auth::getUser_id());
         
          if($classes_i_own && $arr['stdnt_classes'])
          {
            $arr['stdnt_classes'] = array_merge($arr['stdnt_classes'],$classes_i_own);
          }
           
          $data = array();
          if($arr['stdnt_classes']){
//getting all class ids and make them one unique class id from the colums
            $all_classes = array_column($arr['stdnt_classes'], 'class_id');
            $all_classes = array_unique($all_classes);

              foreach ($all_classes as $class_id) {
                $data[] = $class->first('class_id',$class_id);
               
              }
              
          }
          
         } 
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['classes', 'classes'];
          $this->view('classes',[
            'crumbs'=>$crumbs,
            'rows'=>$data]);
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
        $classes = new classes_model();
        if($classes->validate($_POST)){
    
            $classes->insert($_POST);
            $this->redirect('classes');
        }else{
            //errors
            $errors = $classes->errors;
        }

        }

             $crumbs[] = ['Dashboard', ''];
             $crumbs[] = ['classes', 'classes'];
             $crumbs[] = ['add', 'classes/add'];
          $this->view('classes.add',[
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

        $classes = new classes_model();
        $errors = array(); //edit class if you add the class and if you are authorised to 
        if(count($_POST) > 0 && Auth::access('lecturer') && Auth::i_own_content($row))
        {
        
        if($classes->validate($_POST)){

            //$arr['school'] = $_POST['school'];
            
            $classes->update($id,$_POST);
            $this->redirect('classes');
        }else{
            //errors
            $errors = $classes->errors;
        }

        }
        $row = $classes->where('id', $id);
       

             $crumbs[] = ['Dashboard', ''];
             $crumbs[] = ['classes', 'classes'];
             $crumbs[] = ['edit', 'classes/edit'];
        //deny access if you are not alloe to edit
        if(Auth::access('lecturer') && Auth::i_own_content($row)){ 
            $this->view('classes.edit',[
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

            $classes = new classes_model();

            $errors = array();
        //delete class if you add the class and if you are authorised to 
         if(count($_POST) > 0 && Auth::access('lecturer') && Auth::i_own_content($row))
            {
                $classes->delete($id);
                $this->redirect('classes');

            }

            $row = $classes->where('id',$id);

                $crumbs[] = ['Dashboard', ''];
                $crumbs[] = ['classes', 'classes'];
                $crumbs[] = ['delete', 'classes/delete'];
                //deny access if you are not allowed to delete
        if(Auth::access('lecturer') && Auth::i_own_content($row)){ 
            $this->view('classes.delete',[
                'row'=>$row,
                'crumbs'=>$crumbs,
                ]);
        }else{
            $this->view('access-denied');
        }
    }
}


