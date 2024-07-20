<form method="post" class="form mx auto" style="width: 100%; max-width: 400px;">
  <br><h4>Add Lecturer</h4>
    <input autofocus class="form-control" type="text" name="name" placeholder= "lectuerer name">
    <br>
    <a href="<?=ROOT?>/single_class/<?=$row->class_id?>?tab=lecturers">
        <button type="button" class="btn btn-danger">Cancel</button>
     </a>
     <button class="btn btn-primary float-end">Search</button>
    <!-- <div class="clearfix"></div> -->
</form>

<div>
<?php if(isset($results) && $results): ?>
  <?php foreach($rows as $row):?>

    <!-- getting single user information -->
    <?php include(views_path('user')) ?>  

  <?php endforeach; ?>
  <?php else: ?>
    <?php if(count($_POST) > 0):?>
    <center><hr><h4>No results were found</h4></center>
    <?php endif; ?>
<?php endif; ?>

</div>