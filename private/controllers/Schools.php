<?php
//school controller

class Schools extends controller
{
    public function index()
    {
        if(!Auth::logged_in())
        {
            $this->redirect('login');
        }
        $school = new school();

            $data = $school->findAll();

            $crumbs[] = ['Dashboard', ''];
            $crumbs[] = ['schools', 'schools'];
         if(Auth::access('superAdmin')){
                $this->view('schools',[
                    'crumbs'=>$crumbs,
                    'rows'=>$data]);
        }else{
            $this->view('access_denied');
        }
    }
    
    //add school
    public function add()
    {
        if(!Auth::logged_in())
        {
            $this->redirect('login');

        }
        $errors = array();
        if(count($_POST) > 0 && Auth::access('superAdmin'))
        {
        $school = new school();
        if($school->validate($_POST)){

            $arr['school'] = $_POST['school'];
            $arr['date'] = date("Y-m-d H:i:s");
    
            $school->insert($_POST);
            $this->redirect('schools');
        }else{
            //errors
            $errors = $school->errors;
        }

        }

             $crumbs[] = ['Dashboard', ''];
             $crumbs[] = ['schools', 'schools'];
             $crumbs[] = ['add', 'schools/add'];
       
      if(Auth::access('superAdmin')){
          $this->view('schools.add',[
            'errors'=>$errors,
            'crumbs'=>$crumbs,
            ]);
        }else{
            $this->view('access-denied');
        }
    }

//edit school
    public function edit($id =null)
    {
        if(!Auth::logged_in())
        {
            $this->redirect('login');
        }

        $school = new school();

        $errors = array();
        if(count($_POST) > 0 && Auth::access('superAdmin'))
        {
        
        if($school->validate($_POST)){

            //$arr['school'] = $_POST['school'];
            
    
            $school->update($id,$_POST);
            $this->redirect('schools');
        }else{
            //errors
            $errors = $school->errors;
        }

        }
        $row = $school->where('id', $id);
       

             $crumbs[] = ['Dashboard', ''];
             $crumbs[] = ['schools', 'schools'];
             $crumbs[] = ['edit', 'schools/edit'];

         if(Auth::access('superAdmin')){
            $this->view('schools.edit',[
                'row'=>$row,
                'errors'=>$errors,
                'crumbs'=>$crumbs,
                ]);
        }else{
            $this->view('access_denied');
        }
    }


//delete school
    public function delete($id = null)
    {
        if(!Auth::logged_in())
        {
            $this->redirect('login');
        }

        $school = new school();

        $errors = array();
        if(count($_POST) > 0 && Auth::access('superAdmin'))
        {
            $school->delete($id);
            $this->redirect('schools');

        }

        $row = $school->where('id',$id);

            $crumbs[] = ['Dashboard', ''];
            $crumbs[] = ['schools', 'schools'];
            $crumbs[] = ['delete', 'schools/delete'];
     
        if(Auth::access('superAdmin')){
          $this->view('schools.delete',[
            'row'=>$row,
            'crumbs'=>$crumbs,
            ]);
        }else{
            $this->view('access_denied');
        }
    }
}


