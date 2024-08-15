
<!-- Example single danger button -->
<nav class="navbar">
  <center>
    <h5>Test Questions</h5>
    <p><b>Total Questions:</b> <?=$total_question?></p>
</center>

</nav>
<hr>

<?php if(isset($questions) && is_array($questions)): ?>

    <form method="post">
        <?php $num = 0?>
        <?php foreach($questions as $question): $num++?>   
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
       
         <input class="float-right" style="transform: scale(1.4); cursor: pointer;" type="radio" name="<?=$question->id?>" value="<?=$letter?>">
        </li>

       <?php endforeach;?>   

        </ul>
      </div>
       <br>
      <?php endif;?>

      <?php if($question->question_type != 'multiple'): ?>
       <input class="form-control" type="text" name="<?=$question->id?>" placeholder="type your answer here">
       <?php endif;?>

      </div>
    </div>
<?php endforeach;?>

<center><button class="btn btn-primary">submit Answers</button></center>

</form>
<?php endif;?>