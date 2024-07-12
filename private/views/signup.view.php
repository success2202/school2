<?php
//print_r($errors);
?>
<?php $this->view('includes/header') ?>

    <div class="container-fluid">
       <form method ="Post" action="">
   <div class="p-4 mx-auto shadow rounded" style="margin-top: 50px; width: 100%; max-width: 340px;">
   <h2 class="text-center">My School</h2>
   <img src="<?=ROOT?>/assets/logo1.png" class=" border border-primary d-block mx-auto rounded-circle" style="width: 100px" alt="">
   
   <h3>Add User</h3>
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

<input class="my-2 form-control" value="<?=get_var('fname')?>" type="text" name="fname" placeholder="first name"> 
<input class="my-2 form-control" value="<?=get_var('lname')?>" type="text" name="lname" placeholder="last name"> 
<input class="my-2 form-control" value="<?=get_var('email')?>" type="email" name="email" placeholder="email"> 
 
<select class="my-2 form-control" name="gender" id="">
    <option value="">--Select a gender--</option>
    <option <?=get_select('gender','male')?> value="male">Male</option>
    <option <?=get_select('gender','female')?> value="female">Female</option>
</select> 
<select class="my-2 form-control" name="rank" id="">
    <option value="">--Select a Rank--</option>
    <option <?=get_select('rank','student')?> value="student">Student</option>
    <option <?=get_select('rank','reception')?> value="reception">Reception</option>
    <option <?=get_select('rank','lecturer')?> value="lecturer">Lecturer</option>
    <option <?=get_select('rank','admin')?> value="admin">Admin</option>
    <option <?=get_select('rank','superAdmin')?> value="superAdmin">Super Admin</option>
</select> 
<input class="my-2 form-control" value="<?=get_var('password')?>" type="text" name="password" placeholder="password"> 
<input class="my-2 form-control" value="<?=get_var('password2')?>" type="text" name="password2" placeholder="re-type password"> 
<br>
<button class="btn btn-primary float-right">Add User</button>
<button type="button" class="btn btn-danger">Cancel</button>
</div>

</form>
    </div>
    
    <?php $this->view('includes/footer') ?>