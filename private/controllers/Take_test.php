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
    //   echo $tests->get_primary_key('tests');
    //   die;
        $answers = new Answers_model();
        $query = "select question_id,answer from answers where user_id = :user_id && test_id = :test_id";
        $saved_answers = $answers->query($query,[
                'user_id'=> Auth::getUser_id(),
                'test_id'=> $id,
                
        ]);

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['tests', 'tests'];
       
        if($row)
        {
            $crumbs[] = [$row->test,''];
        //setting editable to 0 so that the lecturer wont edit while student is answering the question   
            if(!$row->disabled)
            { 
                $query = "update tests set editable = 0 where id =:id limit 1";
                $tests->query($query,['id'=>$row->id]);
            } 
        }

        $page_tab = 'view';    
        $db = New Database();
// if something was posted
        if(count($_POST) > 0)
        {
            //insert your answer to answer_test table
            $arr1['user_id'] = Auth::getUser_id();
            $arr1['test_id'] = $id;

        
            //check if there is already answered questions on the answered test table
            $check = $db->query("select id from answered_test where user_id = :user_id && test_id = :test_id limit 1", $arr1);
            
            if(!$check){

                $arr1['date'] = date("Y-m-d H:i:s");
                $query = "insert into answered_test (user_id,test_id,date) values (:user_id, :test_id, :date)";
                $db->query($query, $arr1);
            }
            //save answers to database 
            foreach ($_POST as $key => $value) {
                # code...
                if(is_numeric($key)){
                    $arr['user_id'] = Auth::getUser_id();
                    $arr['question_id'] = $key;
                    $arr['date'] = date("Y-m-d H:i:s");
                    $arr['test_id'] = $id;
                    $arr['answer'] = trim($value);

                    //check if answer already exist
                    $query = "select id from answers where user_id = :user_id && test_id = :test_id && question_id = :question_id limit 1 ";
                    $check = $answers->query($query,[
                            'user_id'=> $arr['user_id'],
                            'test_id'=> $arr['test_id'],
                            'question_id'=> $arr['question_id'],
                    ]);
                    if(!$check)
                {
                    $answers->insert($arr);
                    
                }else{
                    $answer_id = $check[0]->id;

                    unset($arr['user_id']);
                    unset($arr['question_id']);
                    unset($arr['date']);
                    unset($arr['test_id']);
                    $answers->update($answer_id,$arr);
                }
                   
                }
            }
            //moving and staying in the next page 
            $page_number = "&page=1";
            if(!empty($_GET['page']))
            {
                $page_number = "&page=".$_GET['page'];
            }
            $this->redirect('take_test/'.$id.$page_number);
        }

        $limit = 4;
        $pager = new Pager($limit);
        $offset = $pager->offset;
       
        $results = false;
        $quest = new Questions_model();
        $questions = $quest->where('test_id',$id, 'asc', $limit, $offset);
        $all_questions = $quest->query('select * from test_questions where test_id =:test_id', ['test_id'=>$id]);
       
        $total_question = is_array($all_questions) ? count($all_questions): 0; //geting total question

        //get answered tests row
        // $arr1=[];
        // $arr1['user_id'] = Auth::getUser_id();
        // $arr1['test_id'] = $id;
        // $data['answered_test_row'] = $db->query("select * from answered_test where user_id = :user_id && test_id = :test_id limit 1", $arr1);
        // if(is_array($data['answered_test_row']))
        // {
        //     $data['answered_test_row'] = $data['answered_test_row'][0];
        // }

        //if its a test submit
        if(isset($_GET['submit'])){
        
            $query = "update answered_test set submitted = 1 where test_id = :test_id && user_id = :user_id limit 1";
            $tests->query($query,['test_id'=>$id, 'user_id'=>Auth::getUser_id()]);
        }

       $data['answered_test_row']  = $tests->get_answered_test($id, Auth::getUser_id());   
       
       $data['submitted'] = false;
       if(isset($data['answered_test_row']->submitted) && $data['answered_test_row']->submitted ==1)
        {
            $data['submitted']  = true;
        }
        
        $data['row']                = $row;
        $data['crumbs']             = $crumbs;
        $data['page_tab']           = $page_tab;
        $data['results']            = $results;
        $data['questions']          = $questions;
        $data['total_question']     = $total_question;
        $data['all_questions']     = $all_questions;
        $data['errors']             = $errors;
        $data['pager']              = $pager;
        $data['saved_answers']      = $saved_answers;
       

        //show($saved_answers);
        $this->view('take-test',$data);

        }


// protected function get_answer($saved_answers, $id)
// {
//     if(!empty($saved_answers)){
//         foreach($saved_answers as $row) {
//             if($id == $row->question_id)
//             {
//                 return $row->answer;
//             }
//         }
//     }
//     return '';
// }


// public function get_answer_percentage($questions, $saved_answers)
// {
//     $total_answer_count = 0;
//     if(!empty($questions))
//     {
//         foreach($questions as $quest){
//             $answer = $this->get_answer($saved_answers, $quest->id);
//             if(trim($answer) != ""){
//                 $total_answer_count++;
//             }
//         }
//     }
//     if($total_answer_count > 0)
//     {
//         $total_questions = count($questions);
//         return ($total_answer_count / $total_questions) * 100;
//     }

//     return 0;
// }

   }


