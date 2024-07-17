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
          $this->view('schools',['rows'=>$data]);
    }
    
    public function add()
    {
        if(!Auth::logged_in())
        {
            $this->redirect('login');

        }
        $errors = array();
        if(count($_POST) > 0)
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
          $this->view('schools.add',[
            'errors'=>$errors,
            ]);
    }
}


