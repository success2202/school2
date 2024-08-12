
<!-- Example single danger button -->
 <nav class="navbar">
  <center>
    <h5>Test Questions</h5>
    <p><b>Total Questions:</b> <?=$total_question?></p>
</center>
<div class="btn-group">
  <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="fa fa-bars"></i> Add Test
  </button>
  <ul class="dropdown-menu dropdown-menu-right">
    <li><a class="dropdown-item" href="<?=ROOT?>/single_test/addquestion/<?=$row->test_id?>?type=multiple">
        Add Multtiple choice Question</a></li>
    <li><a class="dropdown-item" href="<?=ROOT?>/single_test/addquestion/<?=$row->test_id?>?type=objective">
        Add Objective Question</a></li>

    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item" href="<?=ROOT?>/single_test/addquestion/<?=$row->test_id?>">
        Add Subjectiive Question</a></li>
  </ul>
</div>
</nav>
<hr>

<?php if(isset($questions) && is_array($questions)): ?>
  <?php $num = $total_question + 1?>
<?php foreach($questions as $question): $num--?>   
    <div class="card mb-4 shadow">
      <div class="card-header">
       <span class="bg-secondary p-1 text-white rounded"> Question: #<?=$num?> </span> <span class="badge btn btn-secondary float-right p-2"> <?=date("F jS, Y H:i:s a",strtotime($question->date))?> </span>
      </div>
      <div class="card-body">
        <h5 class="card-title"><?=esc($question->question)?></h5><hr>

        <?php if(file_exists($question->image)):?>
          <img src="<?= ROOT . '/' .$question->image?>" style="width:20%;">
        <?php endif;?>
        <hr>
        <p class="card-text"><?=esc($question->comment)?></p>

     <?php 
     $type = "";
     ?>   
    <?php if($question->question_type == 'objective'):
      $type = '?type=objective';
      ?>
        <p class="card-text"><b>Answer</b> <?=esc($question->correct_answer)?></p>
      <?php endif;?>

    <p class="card-text float-right">
    <a href="<?=ROOT?>/single_test/editquestion/<?=$row->test_id?>/<?=$question->id?><?=$type?>">
      <button class="btn btn-info text-white pe-1"><i class="fa fa-edit"></i></button>
    </a>

    <a href="<?=ROOT?>/single_test/deletequestion/<?=$row->test_id?>/<?=$question->id?><?=$type?>">
      <button class="btn btn-danger text-white"><i class="fa fa-trash-alt"></i></button>
      </a>
      </p>
      <!-- </div>
      <div class="card-footer text-muted"> -->
        
      </div>
    </div>
<?php endforeach;?>
<?php endif;?>