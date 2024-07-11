
<?php $this->view('includes/header') ?>

    <div class="container-fluid">
       
   <div class="p-4 mx-auto shadow rounded" style="margin-top: 50px; width: 100%; max-width: 310px;">
   <h2 class="text-center">My School</h2>
   <img src="<?=ROOT?>/assets/logo1.png" class=" border border-primary d-block mx-auto rounded-circle" style="width: 100px" alt="">
   <h3>Login</h3>
<input class="form-control" type="email" name="email" placeholder="email" autofocus> <br>
<input class="form-control" type="password" name="password" placeholder="password"> <br>
<button class="btn btn-primary">Login</button>
</div>

    </div>
    
    <?php $this->view('includes/footer') ?>