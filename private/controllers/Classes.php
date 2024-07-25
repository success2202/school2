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
       
       
        $data = $classes->findAll();

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

