
<?php if(is_object($question)): ?>
<center> <h4>delete Question</h4></center>

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
    <textarea readonly class="form-control" name="question"  placeholder="Type your question" id=""><?=get_var('question', $question->question)?></textarea>
    <div class="input-group mb-3 pt-3">
        <label class="input-group-text" for="inputGroupFile01">comment(optional)</label>
        <input readonly name="comment" value="<?=get_var('comment', $question->comment)?>" type="text" class="form-control" placeholder="comment">
    </div>
    
    <div>
        <?php if(file_exists($question->image)): ?>
            <img src="<?=ROOT. '/'. $question->image ?>" class="d-block mx-auto" style="width: 20%;">
        <?php endif;?>
    </div>

    <a href="<?=ROOT?>/single_test/<?=$row->test_id?>">
          <button class="btn btn-sm btn-primary" type="button"><i class="fa fa-chevron-left">&nbsp;Back</i></button>
    </a>
          <button class="btn btn-sm btn-danger float-right">Delete Question</button>
     <div></div>
</form>

<?php else: ?>
    <center><h4>Sorry!! the question was not found</h4></center> <br>
    <a href="<?=ROOT?>/single_test/<?=$row->test_id?>">
          <button class="btn btn-sm btn-primary" type="button"><i class="fa fa-chevron-left">&nbsp;Back</i></button>
    </a>
<?php endif;?>