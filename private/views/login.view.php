
<?php $this->view('includes/header') ?>

    <div class="container-fluid">
       <form action="" method="Post">
   <div class="p-4 mx-auto shadow rounded" style="margin-top: 50px; width: 100%; max-width: 310px;">
   <h2 class="text-center">HGC SCHOOL</h2>
   <img src="<?=ROOT?>/assets/logo1.png" class=" border border-primary d-block mx-auto rounded-circle" style="width: 100px" alt="">
   <h3>Login</h3>
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
<input class="form-control" value="<?=get_var('email')?>" type="email" name="email" placeholder="email" autofocus> <br>
<input class="form-control" value="<?=get_var('password')?>" type="password" name="password" placeholder="password"> <br>
<button class="btn btn-primary">Login</button>
</div>
</form>
    </div>
    
    <?php $this->view('includes/footer') ?>