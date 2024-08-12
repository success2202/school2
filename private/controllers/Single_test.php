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
        $total_question = count($questions);

        $data['row']                = $row;
        $data['crumbs']             = $crumbs;
        $data['page_tab']           = $page_tab;
        $data['results']            = $results;
        $data['questions']          = $questions;
        $data['total_question']    = $total_question;
        $data['errors']             = $errors;
        $data['pager']              = $pager;

        $this->view('single-test',$data);

        }



public function addquestion($id = '')
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
        $page_tab = 'add-question';

        $limit = 3;
        $pager = new Pager($limit);
        $offset = $pager->offset;

 $quest = new Questions_model();
    if(count($_POST) > 0){
   
    if($quest->validate($_POST)){
        // check for image files
        if($myimage = upload_image($_FILES))
            {
            $_POST['image'] = $myimage;
        }
        $_POST['test_id'] = $id;
        $_POST['date'] = date("Y-m-d H:i:s");

    if(isset($_GET['type']) && $_GET['type'] == "objective"){ 
        $_POST['question_type'] = 'objective';
        
    }else{
        $_POST['question_type'] = 'subjective';
    }
        $quest->insert($_POST);
        $this->redirect('single_test/'.$id);
    }else{
        //errors
        $errors = $quest->errors;
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



public function editquestion($id = '', $quest_id = '')
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
        $page_tab = 'edit-question';

        $limit = 3;
        $pager = new Pager($limit);
        $offset = $pager->offset;
    
     $quest = new Questions_model();
     $question = $quest->first('id', $quest_id);
        if(count($_POST) > 0){
       
        if($quest->validate($_POST)){
            // check for image files
            if($myimage = upload_image($_FILES))
                {
                $_POST['image'] = $myimage;
                if(file_exists($question->image)){
                    unlink($question->image);
                }
            }
        //check the questin type    
            $type = "";
            if($question->question_type == 'objective'){
                $type = '?type=objective';
            }
             
            $quest->update($question->id, $_POST);
            $this->redirect('single_test/'.$id. '/'.$quest_id.$type);
            }else{
                //errors
                $errors = $quest->errors;
            }
    
    }
           
            $results = false;
            $data['row']        = $row;
            $data['crumbs']     = $crumbs;
            $data['page_tab']   = $page_tab;
            $data['results']    = $results;
            $data['errors']     = $errors;
            $data['pager']      = $pager;
            $data['question']   = $question;
    
            $this->view('single-test',$data);
    
            }



    public function deletequestion($id = '', $quest_id = '')
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
        $page_tab = 'delete-question';

        $limit = 3;
        $pager = new Pager($limit);
        $offset = $pager->offset;
    
        $quest = new Questions_model();
        $question = $quest->first('id', $quest_id);
        if(count($_POST) > 0){
               
        if(Auth::access('lecturer'))
        {
        
            $quest->delete($question->id);
            if(file_exists($question->image)){
                unlink($question->image);
            }
            $this->redirect('single_test/'.$id);
            
        }
    } 
        $results = false;
        $data['row']        = $row;
        $data['crumbs']     = $crumbs;
        $data['page_tab']   = $page_tab;
        $data['results']    = $results;
        $data['errors']     = $errors;
        $data['pager']      = $pager;
        $data['question']   = $question;

        $this->view('single-test',$data);

        }     
   }


