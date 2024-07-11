
<?php $this->view('includes/header') ?>

    <div class="container-fluid">
       <form method ="Post" action="">
   <div class="p-4 mx-auto shadow rounded" style="margin-top: 50px; width: 100%; max-width: 340px;">
   <h2 class="text-center">My School</h2>
   <img src="<?=ROOT?>/assets/logo1.png" class=" border border-primary d-block mx-auto rounded-circle" style="width: 100px" alt="">
   <h3>Add User</h3>
<input class="my-2 form-control" type="text" name="fname" placeholder="first name"> 
<input class="my-2 form-control" type="text" name="lname" placeholder="last name"> 
<input class="my-2 form-control" type="email" name="email" placeholder="email"> 

<select class="my-2 form-control" name="gender" id="">
    <option value="">--Select a gender--</option>
    <option value="male">Male</option>
    <option value="female">Female</option>
</select> 
<select class="my-2 form-control" name="rank" id="">
    <option value="">--Select a Rank--</option>
    <option value="student">Student</option>
    <option value="reception">Reception</option>
    <option value="lecturer">Lecturer</option>
    <option value="admin">Admin</option>
    <option value="superAdmin">Super Admin</option>
</select> 
<input class="my-2 form-control" type="text" name="password" placeholder="password"> 
<input class="my-2 form-control" type="text" name="password2" placeholder="re-type password"> 
<br>
<button class="btn btn-primary float-right">Add User</button>
<button type="button" class="btn btn-danger">Cancel</button>
</div>

</form>
    </div>
    
    <?php $this->view('includes/footer') ?>