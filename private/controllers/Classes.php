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
        $errors = array();
        if(count($_POST) > 0)
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
          $this->view('classes.edit',[
            'row'=>$row,
            'errors'=>$errors,
            'crumbs'=>$crumbs,
            ]);
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
        if(count($_POST) > 0)
        {
            $classes->delete($id);
            $this->redirect('classes');

        }

        $row = $classes->where('id',$id);

            $crumbs[] = ['Dashboard', ''];
            $crumbs[] = ['classes', 'classes'];
            $crumbs[] = ['delete', 'classes/delete'];

          $this->view('classes.delete',[
            'row'=>$row,
            'crumbs'=>$crumbs,
            ]);
    }
}


