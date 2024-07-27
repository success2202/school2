<?php $this->view('includes/header')?>
<?php $this->view('includes/nav')?>
<style>
    h1{
        font-size: 80px;
        color: limegreen;
    }

    a:link {
  text-decoration: none;
    }

    .card-header{
        font-weight: bold;
    }

    .card{
        min-width: 250px;
    }
</style>
<div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px;">
   <div class="row justify-content-center">
    
  <?php if(Auth::access('superAdmin')):?>
        <div class="card col-3 shadow rounded m-4 p-0 border"> 
        <a href="<?=ROOT?>/schools">
            <div class="card-header">SCHOOLS </div>
            <h1 class="text=center">
                <i class="fa fa-graduation-cap"></i>
            </h1>
            <div class="card-footer">view all schools</div>
            </a>
        </div>
  <?php endif;?>

 <?php if(Auth::access('admin')):?>
        <div class="card col-3 shadow rounded m-4 p-0 border"> 
        <a href="<?=ROOT?>/users">
         <div class="card-header">STAFFS </div>
            <h1 class="text=center">
                <i class="fa fa-chalkboard-teacher"></i>
            </h1>
            <div class="card-footer">view all staff members</div>
         </a>
        </div>
  <?php endif;?>

  <?php if(Auth::access('reception')):?>
        <div class="card col-3 shadow rounded m-4 p-0 border"> 
        <a href="<?=ROOT?>/students">
            <div class="card-header">STUDENTS </div>
            <h1 class="text=center">
                <i class="fa fa-user-graduate"></i>
            </h1>
            <div class="card-footer">view all studnts</div>
          </a>
        </div>
  <?php endif;?>

        <div class="card col-3 shadow rounded m-4 p-0 border"> 
        <a href="<?=ROOT?>/classes">
            <div class="card-header">CLASSES </div>
            <h1 class="text=center">
                <i class="fa fa-university"></i>
            </h1>
            <div class="card-footer">view all classes</div>
        </a>
        </div>
    
        <div class="card col-3 shadow rounded m-4 p-0 border"> 
        <a href="<?=ROOT?>/tests">
            <div class="card-header">TEST </div>
            <h1 class="text=center">
                <i class="fa fa-file-signature"></i>
            </h1>
            <div class="card-footer">view all tests</div>
        </a>
        </div>
    
     <?php if(Auth::access('admin')):?>
        <div class="card col-3 shadow rounded m-4 p-0 border"> 
        <a href="<?=ROOT?>/statistics">
            <div class="card-header">STATISTICS </div>
            <h1 class="text=center">
                <i class="fa fa-chart-pie"></i>
            </h1>
            <div class="card-footer">view student statistics</div>
          </a>
        </div>
    <?php endif;?>

        <div class="card col-3 shadow rounded m-4 p-0 border"> 
        <a href="<?=ROOT?>/profile">
            <div class="card-header">PROFILE </div>
            <h1 class="text=center">
                <i class="fa fa-id-card"></i>
            </h1>
            <div class="card-footer">view your profile</div>
         </a>
        </div>
    
    <?php if(Auth::access('admin')):?>
        <div class="card col-3 shadow rounded m-4 p-0 border"> 
        <a href="<?=ROOT?>/settings">
            <div class="card-header">SETTINGS </div>
            <h1 class="text=center">
                <i class="fa fa-cogs"></i>
            </h1>
            <div class="card-footer">view app settings</div>
        </a>
        </div>
    <?php endif;?>

        <div class="card col-3 shadow rounded m-4 p-0 border"> 
        <a href="<?=ROOT?>/logout">
            <div class="card-header">LOGOUT </div>
            <h1 class="text=center">
                <i class="fa fa-sign-out-alt"></i>
            </h1>
            <div class="card-footer">logout from the system</div>
          </a>
        </div>
   

   </div>
    </div>
    
    



    <?php $this->view('includes/footer')?>