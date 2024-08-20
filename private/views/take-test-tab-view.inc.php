
<!-- get answer percentage function -->
<?php $percentage = get_answer_percentage($row->test_id, Auth::getUser_id())?>



<div class="container-fluid text-center">
  <div class="text-danger"><?=$percentage?>% Answered</div>
  <div class="bg-primary" style="width: <?=$percentage?>%; height: 15px;"></div>
 
  <?php if($answered_test_row):?>
    <?php if($answered_test_row->submitted):?>
      <div class="text-success">this test has  been submitted</div>
      
      <?php else:?>
        <div class="text-danger">
          this test has not been yet submitted <br>

          <a onclick="submit_test(event)" href="<?=ROOT?>/take_test/<?=$row->test_id?>/?submit=true">
          <button class="btn btn-danger float-right">Submit Test</button>
          </a>

        </div>
       <?php endif;?> 
       <?php endif;?> 
</div>
<nav class="navbar">
  <center>
    <h5>Test Questions</h5>
    <p><b>Total Questions:</b> <?=$total_question?></p>
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
       
          <?php if(!$submitted):?>
         <input class="float-right" style="transform: scale(1.4); cursor: pointer;" type="radio" name="<?=$question->id?>" <?=$myanswer == $letter ? ' checked ':''?> value="<?=$letter?>">
         <?php else:?>
          <?php if($myanswer == $letter):?>
            <i class="fa fa-check float right"></i>
            <?php endif;?>
         <?php endif;?>
        </li>

       <?php endforeach;?>   

        </ul>
      </div>
       <br>
      <?php endif;?>

      <?php if($question->question_type != 'multiple'): ?>

        <!-- if test question not submited  -->
        <?php  if(!$submitted): ?>
         <input  value="<?=$myanswer?>" class="form-control" type="text" name="<?=$question->id?>" placeholder="type your answer here">
        <?php else:?>
          <div>Answer: <?=$myanswer?> </div>
      <?php endif;?>
    <?php endif;?>

      </div>
    </div>
<?php endforeach;?>

<!-- if test is not submited show the save button but if is submitted then remove the save answer button -->
<?php  if(!$submitted): ?>
<center>
  <small>Save your answers before moving to another page</small> <br>
  <button class="btn btn-primary">Save Answers</button>
</center>
<?php endif;?>
</form>
<?php endif;?>
<?php $pager->display() ?>

<script>
  var percent = <?=$percentage?>;
  function submit_test(e)
  {
    if(!confirm("are you sure you want to submit this test!?")){
      e.preventDefault();
      return;
    }

    if(percent < 100){
      if(!confirm("you have only answered "+ percent +"% of the test. are yo sure you still want to submit!?")){
      e.preventDefault();
      return;
      }
    }
  }
</script>