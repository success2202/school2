<?php
//single test controller

class Single_test extends controller
{
    public function index($id = '')
    {
      $errors = array();
      if(!Auth::access('lecturer'))
      {
          $this->redirect('access_denied');
      }
        $tests = new Tests_model();
        $row = $tests->first('test_id', $id);

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['tests', 'tests'];
       
        if($row)
        {
            $crumbs[] = [$row->test,''];
            
        }
//disabled test
if(isset($_GET['disabled'])){

    if($row->disabled){
        $disabled = 0;
    }else{
        $disabled = 1;
    }

        $query = "update tests set disabled = $disabled where id = :id limit 1";
        $tests->query($query,['id'=>$row->id]);
        $this->redirect('single_test/'.$id);
    }

        $page_tab = 'view';
        $student_scores = false;
        if(isset($_GET['tab']) && $_GET['tab'] == "scores")
        {
            //getting students scores
            $page_tab = 'scores';
            $answered_test = New Answered_test();
            $student_scores = $answered_test->query("select * from answered_test where test_id = :test_id && submitted = 1 && marked = 1 order by score desc", ['test_id'=>$id]);
        }

        $limit = 4;
        $pager = new Pager($limit);
        $offset = $pager->offset;
       
        $results = false;
        $quest = new Questions_model();
        $questions = $quest->where('test_id',$id);
        $total_question = is_array($questions) ? count($questions): 0;

        $data['row']                = $row;
        $data['crumbs']             = $crumbs;
        $data['page_tab']           = $page_tab;
        $data['results']            = $results;
        $data['questions']          = $questions;
        $data['total_question']     = $total_question;
        $data['errors']             = $errors;
        $data['pager']              = $pager;
        $data['student_scores']     = $student_scores;

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

        if(isset($_GET['type']) && $_GET['type'] == "multiple"){ 
            $_POST['question_type'] = 'multiple';
            // for multiple
            $num = 0;
            $arr = [];
    $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
    foreach($_POST as $key => $value){
        if(strstr($key, 'choice')){
            $arr[$letters[$num]] = $value;
            $num++;
        }
    }
        $_POST['choices'] = json_encode($arr);

     }else      
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
       // cant edit when student is answering question shows error
            if(!$row->editable){
                $errors[] = "Editing for this test question is disabled";
            }

        if($quest->validate($_POST) && count($errors) == 0 )
        {

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

            if(isset($_GET['type']) && $_GET['type'] == "multiple"){ 
                $_POST['question_type'] = 'multiple';
                // for multiple
                $num = 0;
                $arr = [];
        $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
        foreach($_POST as $key => $value){
            if(strstr($key, 'choice')){
                $arr[$letters[$num]] = $value;
                $num++;
            }
        }
            $_POST['choices'] = json_encode($arr);
            $type = '?type=multiple';
         }else      
            if($question->question_type == 'objective'){
                $type = '?type=objective';
            }
             
            $quest->update($question->id, $_POST);
            $this->redirect('single_test/'.$id. '/'.$quest_id.$type);
            }else{
                //errors
                $errors = array_merge($errors,$quest->errors);
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

        if(!$row->editable){
            $errors[] = "this test question cannot be deleted";
        }

        if(count($_POST) > 0 && count($errors) == 0){
               
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


