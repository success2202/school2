<?php
//take test controller

class Take_test extends controller
{
    public function index($id = '')
    {
      $errors = array();
      if(!Auth::access('student'))
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
        //setting editable to 0 so that the lecturer wont edit while student is answering the question    
            $query = "update tests set editable = 0 where id =:id limit 1";
            $tests->query($query,['id'=>$row->id]);
            
        }
        $page_tab = 'view';

        $limit = 3;
        $pager = new Pager($limit);
        $offset = $pager->offset;
       
        $results = false;
        $quest = new Questions_model();
        $questions = $quest->where('test_id',$id, 'asc');
        $total_question = is_array($questions) ? count($questions): 0;

        $data['row']                = $row;
        $data['crumbs']             = $crumbs;
        $data['page_tab']           = $page_tab;
        $data['results']            = $results;
        $data['questions']          = $questions;
        $data['total_question']    = $total_question;
        $data['errors']             = $errors;
        $data['pager']              = $pager;

        $this->view('take-test',$data);

        }

   }


