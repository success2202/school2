<form method="post" class="form mx-auto" style="width:100%;max-width: 400px;">
  <br><center> <h4>Add Student</h4></center>
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


    <input value="<?=get_var('name')?>" autofocus class="form-control" type="text" name="name" placeholder= "student name">
    <br>
    <a href="<?=ROOT?>/single_class/<?=$row->class_id?>?tab=students">
        <button type="button" class="btn btn-danger">Cancel</button>
     </a>
     <button class="btn btn-primary float-right" name="search">Search</button>
    <div class="clearfix"></div>
</form>
<br>

<div class="card-group justify-content-center">

<form method="post">

<?php if(isset($results) && $results):?>
  
  <?php foreach($results as $row):?>
    <!-- includes user single -->
    <?php include(views_path('user')) ?>
    
      <?php endforeach; ?>
    </table>
  <?php else: ?>
    
    <?php if(count($_POST) > 0):?>
    <center><hr><h4>No results were found</h4></center>
    <?php endif; ?>
<?php endif; ?>
</form>
</div>