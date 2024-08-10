<?php
//single test controller

class Single_test extends controller
{
    public function index($id = '')
    {
      $errors = array();
      if(!Auth::logged_in())
      {
          $this->redirect('login');
      }
        $tests = new Tests_model();
        $row = $tests->first('test_id', $id);

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['tests', 'tests'];
       
        if($row)
        {
            $crumbs[] = [$row->test,''];
            
        }
        $page_tab = 'view';

        $limit = 3;
        $pager = new Pager($limit);
        $offset = $pager->offset;
       
        $results = false;
        $quest = new Questions_model();
        $questions = $quest->where('test_id',$id);

        $data['row']      = $row;
        $data['crumbs']   = $crumbs;
        $data['page_tab'] = $page_tab;
        $data['results']  = $results;
        $data['questions']  = $questions;
        $data['errors']  = $errors;
        $data['pager']  = $pager;

        $this->view('single-test',$data);

        }



public function addsubjective($id = '')
    {
      $errors = array();
      if(!Auth::logged_in())
      {
          $this->redirect('login');
      }
        $tests = new Tests_model();
        $row = $tests->first('test_id', $id);

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['tests', 'tests'];
       
        if($row)
        {
            $crumbs[] = [$row->test,''];
            
        }
        $page_tab = 'add-subjective';

        $limit = 3;
        $pager = new Pager($limit);
        $offset = $pager->offset;

 $quest = new Questions_model();
    if(count($_POST) > 0){
   
    if($quest->validate($_POST)){

        $_POST['test_id'] = $id;
        $_POST['date'] = date("Y-m-d H:i:s");
        $_POST['question_type'] = 'subjective';
        

        $quest->insert($_POST);
        $this->redirect('single_test/'.$id);
    }else{
        //errors
        $errors = $school->errors;
    }

}
       
        $results = false;
        $data['row']        = $row;
        $data['crumbs']     = $crumbs;
        $data['page_tab']   = $page_tab;
        $data['results']    = $results;
        $data['errors']     = $errors;
        $data['pager']      = $pager;

        $this->view('single-test',$data);

        }
   }


