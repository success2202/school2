<?php $this->view('includes/header')?>
<?php $this->view('includes/nav')?>

    <div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px;">
                    <center> <h4>Edit profile</h4>  </center>
    <?php if($row): ?>

    <?php  
      $image = get_image($row->image, $row->gender); 
    ?>
 <form method ="Post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-4 col-md-3">
        <img src="<?=$image?>" class=" bg-light d-block border mx-auto" style="width: 150px" alt="">
        <br>
        <?php if(Auth::access('lecturer') || Auth::i_own_content($row)): ?>
        <div class="text-center"> 
        <label for="image_browser" class="btn-sm btn btn-info text-white">
            <input onchange="display_image_name(this.files[0].name)" id="image_browser" type="file" name="image" style="display: none;">
            Browse Image
        </label> 
        <br>
        <small class="file_info text-muted"></small>
        
        <!-- <button class="btn-sm btn btn-info text-white">Browse Image</button>
            -->
        </div>
        <?php endif;?>
    </div>
        <div class="col-sm-9 col-md-8 bg-light p-2">
            <div class="p-4 mx-auto shadow rounded">
            
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

            <input class="my-2 form-control" value="<?=get_var('fname', $row->firstname)?>" type="text" name="fname" placeholder="first name"> 
            <input class="my-2 form-control" value="<?=get_var('lname', $row->lastname)?>" type="text" name="lname" placeholder="last name"> 
            <input class="my-2 form-control" value="<?=get_var('email', $row->email)?>" type="email" name="email" placeholder="email"> 
            
            <select class="my-2 form-control" name="gender" id="">
                <option <?=get_select('gender', $row->gender)?> value="<?=$row->gender?>"><?=ucwords($row->gender)?></option>
                <option <?=get_select('gender', 'male')?> value="male">Male</option>
                <option <?=get_select('gender', 'female')?> value="female">Female</option>
            </select> 

            <select class="my-2 form-control" name="rank" id="">
                <option <?=get_select('rank',$row->rank)?> value=""><?=ucwords($row->rank)?></option>
                <option <?=get_select('rank','student')?> value="student">Student</option>
                <option <?=get_select('rank','reception')?> value="reception">Reception</option>
                <option <?=get_select('rank','lecturer')?> value="lecturer">Lecturer</option>
                <option <?=get_select('rank','admin')?> value="admin">Admin</option>
                
                <?php if(Auth::getrank() == 'superAdmin'): ?>
                <option <?=get_select('rank','superAdmin')?> value="superAdmin">Super Admin</option>
                    <?php endif;?>

            </select> 
          

            <input class="my-2 form-control" value="<?=get_var('password')?>" type="text" name="password" placeholder="password"> 
            <input class="my-2 form-control" value="<?=get_var('password2')?>" type="text" name="password2" placeholder="re-type password"> 
            <br>

                <button class="btn btn-primary float-right">Save Changes</button>

                <a href="<?=ROOT?>/profile/<?=$row->user_id?>">
                <button type="button" class="btn btn-danger">Back to Profile</button>
            </a>

            </div>

        </div>
    </div>

</form>
<br>

    <?php else: ?>
        <h4 style="text-align:center;"> User Profile not found</h4>
    <?php endif; ?>
    </div>

    <script>
        function display_image_name(file_name)
        {
            document.querySelector(".file_info").innerHTML = '<b>selected file: </b><br>' + file_name;
        }
    </script>
    <?php $this->view('includes/footer')?>