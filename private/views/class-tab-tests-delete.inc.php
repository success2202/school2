
<div class="card-group justify-content-center">
<?php if(isset($test_row) && is_object($test_row)): ?>
<form method="post">
    <center> <h3> are you sure you want to delete this test</h3> </center>

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
<label for="">Test Name</label>
    <input readonly class="form-control" type="text" value="<?= get_var('test', $test_row->test);?>" name="test" placeholder="Test Title"> <br>
<label for="">Test description</label>
    <textarea readonly class="form-control" placeholder="enter test description" name="description" id=""><?= get_var('description', $test_row->description);?></textarea> <br>
    
    <input class="btn btn-danger float-right" type="submit" value="Delete">

    <a href="<?=ROOT?>/single_class/<?=$row->class_id?>?tab=tests">
        <input class="btn btn-success text-white" type="button" value="Back">
    </a>
</form>


<?php else:?>
 <center> sorry, the test was not found </center><br><br>
  <a href="<?=ROOT?>/single_class/<?=$row->class_id?>?tab=tests">
        <input class="btn btn-success text-white " type="button" value="Back">
    </a>
  <?php endif; ?>
</div>