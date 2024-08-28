<?php
//mark test controller

class Mark_test extends controller
{
    public function index($id = '',$user_id = '')
    {
      $errors = array();
      if(!Auth::access('lecturer'))
      {
          $this->redirect('access_denied');
      }
        $tests = new Tests_model();
        $row = $tests->first('test_id', $id);
    //   echo $tests->get_primary_key('tests');
    //   die;
        $answers = new Answers_model();
        $query = "select question_id,answer,answer_mark from answers where user_id = :user_id && test_id = :test_id";
        $saved_answers = $answers->query($query,[
                'user_id'=> $user_id,
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
            //save answers to database 
            foreach ($_POST as $key => $value) {
                # code...
                if(is_numeric($key)){
                    $arr['user_id'] = $user_id;
                    $arr['question_id'] = $key;
                    $arr['test_id'] = $id;
                    $arr['answer_mark'] = trim($value);

                    //check if answer already exist
                    $query = "select id from answers where user_id = :user_id && test_id = :test_id && question_id = :question_id limit 1 ";
                    $check = $answers->query($query,[
                            'user_id'=> $arr['user_id'],
                            'test_id'=> $arr['test_id'],
                            'question_id'=> $arr['question_id'],
                    ]);
            if($check)
                {
                   
                    $answer_id = $check[0]->id;

                    unset($arr['user_id']);
                    unset($arr['question_id']);
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
            $this->redirect('mark_test/'.$id.'/'.$user_id.$page_number);
        }

        $limit = 4;
        $pager = new Pager($limit);
        $offset = $pager->offset;
       
        $results = false;
        $quest = new Questions_model();
        $questions = $quest->where('test_id',$id, 'asc', $limit, $offset);
        $all_questions = $quest->query('select * from test_questions where test_id =:test_id', ['test_id'=>$id]);
       
        $total_question = is_array($all_questions) ? count($all_questions): 0; //geting total question
//if its a test unsubmit
        if(isset($_GET['unsubmit'])){
        
            $query = "update answered_test set submitted = 0, submitted_date = :sub_date where test_id = :test_id && user_id = :user_id limit 1";
            $tests->query($query,[
                'test_id'=>$id,
             'user_id'=>$user_id,
            'sub_date'=>''
            ]);
        }
//if its an auto mark
        if(isset($_GET['auto_mark'])){
        
            $query = "select id,correct_answer from test_questions where test_id = :test_id && (question_type = 'multiple' || question_type = 'objective') ";
            $original_question = $quest->query($query,[
                'test_id'=>$id,
             
            ]);
            if($original_question){
                foreach($original_question as $question_row){
                    $query = "select id,answer from answers where user_id = :user_id && test_id = :test_id && question_id = :question_id limit 1";
                    $answer_row = $tests->query($query, [
                        'user_id'=>$user_id,
                        'test_id'=>$id,
                        'question_id'=>$question_row->id,
                    ]);

                    if($answer_row){
                    
                    $answer_row = $answer_row[0];
                    $correct = strtolower(trim($question_row->correct_answer));
                    $student_answer = strtolower(trim($answer_row->answer));
                
                if($correct == $student_answer){
                    //this answer is correct
                    $answers->update($answer_row->id, ['answer_mark'=>1]);
                }else{
                    // this answer is wrong
                    $answers->update($answer_row->id, ['answer_mark'=>2]);
                }
             }
          }
        }
        //redirect to same page 
        $this->redirect('mark_test/'.$id.'/'.$user_id.$page_number);
    }

        // if is set as marked
        if(isset($_GET['set_marked']) && (get_mark_percentage($id, $user_id) >= 100)){
        
            $query = "update answered_test set marked = 1, marked_by = :mark_by, marked_date = :mark_date, score = :score where test_id = :test_id && user_id = :user_id limit 1";
            $tests->query($query,['test_id'=>$id,
             'user_id'=>$user_id,
             'mark_by'=>Auth::getUser_id(),
            'mark_date'=>date("Y-m-d H:i:s"),
            'score'=>get_score_percentage($id, $user_id),
            ]);
            $this->redirect('mark_test/'.$id.'/'.$user_id);
        }

       $data['answered_test_row']  = $tests->get_answered_test($id, $user_id);   
//set submitted variable
       $data['submitted'] = false;
       if(isset($data['answered_test_row']->submitted) && $data['answered_test_row']->submitted ==1)
        {
            $data['submitted']  = true;
        }
//set marked variables 
        $data['marked'] = false;
        if(isset($data['answered_test_row']->marked) && $data['answered_test_row']->marked ==1)
         {
             $data['marked']  = true;
         }

        //get student information
        if($data['answered_test_row']){

            $user = new User();
            $data['student_row'] = $user->first('user_id', $data['answered_test_row']->user_id);
         
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
        $data['user_id']      = $user_id;
       

        //show($saved_answers);
        $this->view('mark-test',$data);

        }

   }


