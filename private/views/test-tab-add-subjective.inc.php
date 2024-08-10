<center> <h4>Add Subjective Questions</h4></center>

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

<label for="">Question:</label>
    <textarea autofocus class="form-control" name="question" placeholder="Type your question" id=""></textarea>
    <div class="input-group mb-3 pt-4">
        <label class="input-group-text" for="inputGroupFile01"><i class="fa fa-image"></i>&nbsp;image</label>
        <input type="file" class="form-control" id="inputGroupFile01">
    </div>

    <a href="<?=ROOT?>/single_test/<?=$row->test_id?>">
          <button class="btn btn-sm btn-primary" type="button"><i class="fa fa-chevron-left">&nbsp;Back</i></button>
    </a>
          <button class="btn btn-sm btn-danger float-right">Save Question</button>
     <div></div>
</form>