<div class="card-group justify-content-center">

<form method="post">
    <h3>Add New test</h3>

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

    <input autofocus class="form-control" type="text" value="<?= get_var('test');?>" name="test" placeholder="Test Title"> <br>
    <textarea class="form-control" placeholder="enter test description" name="description" id=""><?= get_var('description');?></textarea> <br>
    <input class="btn btn-primary float-right" type="submit" value="Create">

    <a href="<?=ROOT?>/single_class/<?=$row->class_id?>?tab=tests">
        <input class="btn btn-danger text-white" type="button" value="Cancel">
    </a>
</form>

</div>