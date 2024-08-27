
<!-- get answer percentage function -->
<?php $percentage = get_answer_percentage($row->test_id, $user_id)?>
<?php $marked_percentage = get_mark_percentage($row->test_id, $user_id)?>


<div class="container-fluid text-center">
  <div class="text-danger"><?=$percentage?>% Answered</div>
  <div class="bg-primary" style="width: <?=$percentage?>%; height: 15px;"></div>
 
  <!-- get mar percentage function -->
  <div class="text-danger"><?=$marked_percentage?>% Marked</div>
  <div class="bg-primary" style="width: <?=$marked_percentage?>%; height: 15px;"></div>

  <?php if($answered_test_row):?>
    <?php if($answered_test_row->submitted && !$marked):?>

      <div class="text-success">this test has  been submitted</div>
      <a onclick="unsubmit_test(event)" href="<?=ROOT?>/mark_test/<?=$row->test_id?>/<?=$answered_test_row->user_id?>/?unsubmit=true">
          <button class="btn mx-1 btn-danger float-right">Unsubmit Test</button>
      </a>

      <a onclick="set_test_as_marked(event)" href="<?=ROOT?>/mark_test/<?=$row->test_id?>/<?=$answered_test_row->user_id?>/?set_marked=true">
      <button class="btn mx-1 btn-primary float-right">Set Test as Marked</button>
      </a>
        
      <a onclick="auto_mark(event)" href="<?=ROOT?>/mark_test/<?=$row->test_id?>/<?=$answered_test_row->user_id?>/?auto_mark=true">
      <button class="btn mx-1 btn-info float-right">Auto Mark</button>
      </a>

       <?php endif;?> 
       <?php endif;?> 
</div>

<?php if($marked): ?>
  <?php $score_percentage = get_score_percentage($row->test_id, $user_id)?>
    <center>
      <small style="font-size: 15px;">Test Score</small> <b style="font-size: 25px;" ><?=number_format($score_percentage,2)?>%</b>
    </center>
    <nav class="navbar">
<?php endif;?> 

  <center>
    <h5>Test Questions</h5>
    <p><b>Total Questions:</b> #<?=$total_question?></p>
</center>

</nav>
<hr>

<?php if(isset($questions) && is_array($questions)): ?>

    <form method="post">

        <?php $num = $pager->offset; ?>
      <?php foreach($questions as $question): $num++?>  

    <?php  
    //get answer function
        $myanswer = get_answer($saved_answers, $question->id);
        $mymark = get_answer_mark($saved_answers, $question->id);
    ?> 
        <div class="card mb-4">
        <div class="card-header">
        <span class="bg-secondary p-1 text-white rounded"> Question: #<?=$num?> </span> <span class="badge btn btn-secondary float-right p-2"> <?=date("F jS, Y H:i:s a",strtotime($question->date))?> </span>
        </div>
        <div class="card-body">
            <h5 class="card-title"><?=esc($question->question)?></h5><hr>

            <?php if(file_exists($question->image)):?>
            <img src="<?= ROOT . '/' .$question->image?>" style="width:20%;">
            <?php endif;?>
            
            <p class="card-text"><?=esc($question->comment)?></p>

     <?php 
     $type = "";
     ?>   
    <?php if($question->question_type == 'objective'):
      $type = '?type=objective';
      ?>
      <?php endif;?>

      <?php if($question->question_type == 'multiple'):
      $type = '?type=multiple';
      ?>

      <div class="card" style="width: 18rem;">
        <div class="card-header">
          Select the correct answer
        </div>
        <ul class="list-group list-group-flush">

       <?php $choices = json_decode($question->choices);?>

       <?php foreach($choices as $letter => $answer):?>   
          
        <li class="list-group-item"><?=$letter?>: <?=$answer?>
          <?php if($myanswer == $letter):?>
            <i class="fa fa-check float right"></i>
            <?php endif;?>
        </li>

       <?php endforeach;?>   

        </ul>
      </div>
       <br>

       <hr>
    <b>Teacher's Mark:</b>
    <?php if(!$marked):?>
       <div class="form-check">

        <input <?=($mymark == 1) ? 'checked':''?> class="form-check-input" type="radio" name="<?=$question->id?>" value="1" id="flexRadioDefaultcorrect<?=$num?>">
        <label class="form-check-label" for="flexRadioDefaultcorrect<?=$num?>">
          Correct
        </label>

    </div>

    <div class="form-check">

      <input <?=($mymark == 2) ? 'checked':''?> class="form-check-input" type="radio" name="<?=$question->id?>" value="2" id="flexRadioDefaultwrong<?=$num?>">
      <label class="form-check-label" for="flexRadioDefaultwrong<?=$num?>">
        Wrong
      </label>

     </div>
     
     <?php else:?>
      <div style="font-size: 25px;">
        <?=($mymark == 1) ? '<i class="fa fa-check float-right"></i>':'<i class="fa fa-times float-right"></i>'?> 
      </div>
      <?php endif;?>
      <?php endif;?>

      <?php if($question->question_type != 'multiple'): ?>
        <div>Answer: <?=$myanswer?> </div>
        
        <hr>
    <b>Teacher's Mark:</b>
    <?php if(!$marked):?>
      <div class="form-check">
        <input <?=($mymark == 1) ? 'checked':''?> class="form-check-input" type="radio" name="<?=$question->id?>" value="1" id="flexRadioDefaultcorrect<?=$num?>">
        <label class="form-check-label" for="flexRadioDefaultcorrect<?=$num?>">
          Correct
        </label>
    </div>
    <div class="form-check">
      <input <?=($mymark == 2) ? 'checked':''?> class="form-check-input" type="radio" name="<?=$question->id?>" value="2" id="flexRadioDefaultwrong<?=$num?>">
      <label class="form-check-label" for="flexRadioDefaultwrong<?=$num?>">
        Wrong
      </label>
  </div>
  <?php else:?>
    <div style="font-size: 25px;">
          <?=($mymark == 1) ? '<i class="fa fa-check float-right"></i>':'<i class="fa fa-times float-right"></i>'?>
      
    </div>
        
      <?php endif;?>
    <?php endif;?>

      </div>
    </div>
<?php endforeach;?>

<!-- if test is not submited show the save button but if is submitted then remove the save answer button -->
<?php  if(!$marked): ?>
<center>
  <small>Save mark answers before moving to another page to mark</small> <br>
  <button class="btn btn-primary">Save Marked</button>
</center>
<?php endif;?>
</form>
<?php endif;?>
<?php $pager->display() ?>

<script>
  var percent = <?=$percentage?>;
  function unsubmit_test(e)
  {
    if(!confirm("are you sure you want to remove this test from submission list!?")){
      e.preventDefault();
      return;
    }

  }

  function auto_mark(e)
  {
    if(!confirm("This action may override any custom marks you have saved are you sure you want to auto mark!?")){
      e.preventDefault();
      return;
    }

  }
  function set_test_as_marked(e)
  {
    var percent = <?=$marked_percentage?>;
    if(percent < 100){
      e.preventDefault();
      alert(" you have only "+percent+"% of the questions. you can only set test as marked after marking all questions");
      return;
    }
    if(!confirm("you wont be able to mark after this aaction ..Continue!!!!!!?")){
      e.preventDefault();
      return;
    }
  }
</script>