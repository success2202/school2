
<?php
$quest_type = 'subjective';
if(isset($_GET['type']) && $_GET['type'] == 'objective'){
    $quest_type = 'objective';
}else
    if(isset($_GET['type']) && $_GET['type'] == 'multiple'){
        $quest_type = 'multiple_choice';
    }


?>
<?php if(is_object($question)): ?>
<center> <h4>Edit <?=$quest_type?> Question</h4></center>

<form method="post" enctype="multipart/form-data">
<?php if(count($errors)>0):?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Error!</strong>
        <?php foreach($errors as $error):?>
            <br><?=$error?>
            <?php endforeach;?>
        <span  type="button" class="close" data-bs-dismiss="alert" aria-label="Close"> <br>
            <span aria-hidden="true">&times;</span>
        </span>
    </div>
<?php endif;?>

<label>Question:</label>
    <textarea autofocus class="form-control" name="question"  placeholder="Type your question" id=""><?=get_var('question', $question->question)?></textarea>
    <div class="input-group mb-3 pt-3">
        <label class="input-group-text" for="inputGroupFile01">comment(optional)</label>
        <input name="comment" value="<?=get_var('comment', $question->comment)?>" type="text" class="form-control" placeholder="comment">
    </div>

    <!-- <div class="input-group mb-3 pt-3">
        <input name="comment" type="text" class="form-control" placeholder="comment(optional)">
        </div> -->

    <div class="input-group mb-3">
        <label class="input-group-text" for="inputGroupFile01"><i class="fa fa-image"></i>&nbsp;image(optional)</label>
        <input type="file" name="image" class="form-control" id="inputGroupFile01">
    </div>
    
    <div>
        <?php if(file_exists($question->image)): ?>
            <img src="<?=ROOT. '/'. $question->image ?>" class="d-block mx-auto" style="width: 20%;">
        <?php endif;?>
            </div>

    <?php if(isset($_GET['type']) && $_GET['type'] == "objective"): ?>
        <div class="input-group mb-3">
            <label class="input-group-text" for="inputGroupFile01">Answer</label>
            <input type="text" name="correct_answer" value="<?=get_var('correct_answer', $question->correct_answer)?>" class="form-control" id="inputGroupFile012" placeholder="enter the correct answer here">
        </div>
    <?php endif;?>

    <?php if(isset($_GET['type']) && $_GET['type'] == "multiple"): ?>
        <div class="card" style="">
        <div class="card-header bg-info text-white">
            multiple Choice Answers <button onclick="add_choices()" type="button" class="btn btn-warning btn-sm float-right">Add Choice</button>
        </div>
        <ul class="list-group list-group-flush choice-list">

    <?php if(isset($_POST['choice0'])):?>
        <?php
        //check for multiple choice answers
        $num = 0;
        $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
        
    foreach($_POST as $key => $value){
        if(strstr($key, 'choice')){
            ?>
            <li class="list-group-item">
                <?=$letters[$num]?> : <input type="text" class="form-control" value="<?=$value?>" name="<?=$key?>" placeholder="type your answwe here"> 
                <label style="cursor: pointer;"> <input type="radio" <?=$letters[$num] == $_POST['correct_answer'] ? 'checked' : '';?> value ="<?=$letters[$num]?>" name="correct_answer"> Correct Answer </label>
            </li> 
            <?php 
            $num++;
        }
    }
    ?>
    <?php else:?>
        <?php $choices = json_decode($question->choices); $num = 0;?>
        <?php foreach($choices as $letter => $answer): ?>
            <li class="list-group-item">
               <?=$letter?> : <input type="text" class="form-control" name="choice<?=$num?>" placeholder="type your answwe here" value="<?=$answer?>"> 
               <label style="cursor: pointer;"><input type="radio" <?=$letter == $question->correct_answer ? 'checked' : '';?> value="<?=$letter?>" name="correct_answer"> Correct Answer </label>
            </li>
            <?php $num++;?>
            <!-- <li class="list-group-item">
               B : <input type="text" class="form-control" name="choice1" placeholder="type your answwe here"> 
           <label style="cursor: pointer;"><input type="radio" value="B" name="correct_answer"> Correct Answer </label>
            </li> -->
        <?php endforeach;?>
    <?php endif;?>
        
        </ul>

        </div><br>
    <?php endif;?>

    <a href="<?=ROOT?>/single_test/<?=$row->test_id?>">
          <button class="btn btn-sm btn-primary" type="button"><i class="fa fa-chevron-left">&nbsp;Back</i></button>
    </a>
          <button class="btn btn-sm btn-danger float-right">Save Question</button>
     <div></div>
</form>

<?php else: ?>
    <center><h4>Sorry!! the question was not found</h4></center> <br>
    <a href="<?=ROOT?>/single_test/<?=$row->test_id?>">
          <button class="btn btn-sm btn-primary" type="button"><i class="fa fa-chevron-left">&nbsp;Back</i></button>
    </a>
<?php endif;?>