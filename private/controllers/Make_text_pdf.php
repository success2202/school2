<?php
//make  text pdf controller

class Make_text_pdf extends controller
{
    function index( $id = '',$user_id = '')
    {
       
        $errors = array();
       
          $tests = new Tests_model();
          $row = $tests->first('test_id', $id);
      
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
  
          $limit = 3000;
          $pager = new Pager($limit);
          $offset = $pager->offset;
         
          $results = false;
          $quest = new Questions_model();
          $questions = $quest->where('test_id',$id, 'asc', $limit, $offset);
          $all_questions = $quest->query('select * from test_questions where test_id =:test_id', ['test_id'=>$id]);
         
          $total_question = is_array($all_questions) ? count($all_questions): 0; //geting total question
 
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

          extract($data);
        ?>

        <?php if($row && $answered_test_row && $answered_test_row->submitted): ?>
        
            <style>
                table{
                    width:100%;
                    background-color:rgba(255,255,255,0.8);
                    color:#0f54c4;
                    font-family: Garuda;
                }

                table, th, td{
                    border:1px solid #999;
                    border-collapse: collapse;
                }

                th, td{
                    padding: 5px;
                }

                td a{
                    text-decoration:none;
                    color:#000;
                }

                th{
                    color:#d1d1d1;
                    background-color:#434a54;
                }

                
            </style>
            <br>

        <div style="font-family: Garuda; font-size: 18px; max-width: 1000px; margin: auto">
            <table>
                
                <tr>
                    <td colspan="4" style="font-size :20px; text-align :center;">Test: <?=esc(ucwords($row->test))?></td>
                </tr>

                 <tr> 
                    <th>Class: </th> <td> <?=$row->class->class?></td>
                    <th>Student Name: </th> <td> <?=$student_row->firstname?><?=$student_row->lastname?></td>
                </tr>

                <tr>
                    <th>Created by:</th>
                    <td><?=esc($row->user->firstname)?> <?=esc($row->user->lastname)?> </td>
                    <th>Date Created:</th><td><?=get_date($row->date)?></td>
                </tr>
               
              
            <tr>
                <?php $active = $row->disabled ? "No": "Yes";?>
               <td colspan = "4"><b>Test Description : </b> <?=esc($row->description)?></td>
            </tr>

        </table>
        <br>

                <!-- get answer percentage function -->
        <?php $percentage = get_answer_percentage($row->test_id, $user_id)?>
        <?php $marked_percentage = get_mark_percentage($row->test_id, $user_id)?>


        <div class="container-fluid text-center">
        <span><?=$percentage?>% Answered | <?=$marked_percentage?>% Marked</span>
        
        </div>

    <?php if($marked): ?>
        <?php $score_percentage = get_score_percentage($row->test_id, $user_id)?>
            <center>
            <small style="font-size: 15px;">Test Score</small> <b style="font-size: 25px;" ><?=$score_percentage?>%</b>
            </center>
            <nav class="navbar">
        <?php endif;?> 

        <center>
            <p><b>Total Questions:</b> #<?=$total_question?></p>
        </center>

        </nav>
        <hr>

        <?php if(isset($questions) && is_array($questions)): ?>

                <?php $num = $pager->offset; ?>
            <?php foreach($questions as $question): $num++?>  

            <?php  
            //get answer function
                $myanswer = get_answer($saved_answers, $question->id);
                $mymark = get_answer_mark($saved_answers, $question->id);
            ?> 
                <div>
                <div >
                <span> Question: #<?=$num?> </span> 
                </div>
                <div >
                    <h5 ><?=esc($question->question)?></h5><hr>

                    <?php if(file_exists($question->image)):?>
                    <img src="<?= ROOT . '/' .$question->image?>" style="width:20%;">
                    <?php endif;?>
                    
                    <p><?=esc($question->comment)?></p>

            <?php 
            $type = "";
            ?>   
            <div style="background-color: #87b5d3; padding: 10px">

            <?php if($question->question_type == 'objective'):
            $type = '?type=objective';
            ?>
            <?php endif;?>

            <?php if($question->question_type == 'multiple'):
            $type = '?type=multiple';
            ?>

            <b>Teacher's Mark:</b>
            
            <div style="font-size: 20px; float:right;">
                <?=($mymark == 1) ? 'correct':'wrong'?> 
            </div>
            <?php endif;?>

            <?php if($question->question_type != 'multiple'): ?>
                <div>Student Answer: <?=$myanswer?> </div>
                
               
            <b>Teacher's Mark:</b>

            <div style="font-size: 20px; float:right;">
                <?=($mymark == 1) ? 'correct':'wrong'?>
            
            </div>
                
            <?php endif;?>
            </div>
            </div>
        </div><hr>
        <?php endforeach;?>

        <!-- if test is not submited show the save button but if is submitted then remove the save answer button -->


        <?php endif;?>
                
            </div>
        
        <?php endif;?>
    <?php
        
    }
    
}


