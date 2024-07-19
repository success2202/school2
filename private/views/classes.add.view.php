<?php $this->view('includes/header')?>
<?php $this->view('includes/nav')?>

<div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px;">
<?php $this->view('includes/crumbs',['crumbs'=>$crumbs])?>

<div class="card-group justify-content-center">

<form method="post">
    <h3>Add New class</h3>

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

    <input autofocus class="form-control" type="text" value="<?= get_var('class');?>" name="class" placeholder="Class Name"> <br>
    <input class="btn btn-primary float-right" type="submit" value="Create">
    <a href="<?=ROOT?>/classes">
        <input class="btn btn-danger text-white" type="button" value="Cancel">
    </a>
</form>

</div>

    </div> 
    

    <?php $this->view('includes/footer')?>