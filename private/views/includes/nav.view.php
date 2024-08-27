

<style>
     nav ul li a:hover{
        width: 110px;
        text-align: center;
        border-left: solid thin #eee;
        border-left: solid thin #fff;
    }
    nav ul li a:hover{
        background-color: grey;
        color: white !important;
       
    }

    .active-nav{
      background-color: #007bff;
      color: white !important;
    }


</style>
<nav class="navbar navbar-expand-lg navbar-light bg-light p-2">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?=ROOT?>">
    <img src="<?=ROOT?>/assets/logo1.png" class="" style="width: 70px" alt="">
    <?= Auth::getschool_name()?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link <?=$this->controller_name() == 'Home' ? 'active-nav' :''?>" href="<?=ROOT?>">DASHBOARD</a>
        </li>
        <?php if(Auth::access('superAdmin')):?>
          <li class="nav-item">
            <a class="nav-link <?=$this->controller_name() == 'School' ? 'active-nav' :''?>" href="<?=ROOT?>/schools">SCHOOLS</a>
          </li> 
        <?php endif;?>

        <?php if(Auth::access('admin')):?>
          <li class="nav-item">
            <a class="nav-link <?=$this->controller_name() == 'Users' ? 'active-nav' :''?>" href="<?=ROOT?>/users">STAFF</a>
          </li>  
        <?php endif;?>

        <?php if(Auth::access('reception')):?>
          <li class="nav-item">
            <a class="nav-link <?=$this->controller_name() == 'Students' ? 'active-nav' :''?>" href="<?=ROOT?>/students">STUDENTS</a>
          </li>  
        <?php endif;?>

        <li class="nav-item">
          <a class="nav-link <?=$this->controller_name() == 'Classes' ? 'active-nav' :''?>" href="<?=ROOT?>/classes">CLASSES</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?=$this->controller_name() == 'Tests' ? 'active-nav' :''?>" href="<?=ROOT?>/tests">TEST</a>
        </li>

        <?php if(Auth::access('lecturer')):?>
          <li class="nav-item">
            <a class="nav-link <?=$this->controller_name() == 'To_mark' ? 'active-nav' :''?>" style="position: relative" href="<?=ROOT?>/to_mark">UNMARKED
              <?php
               //notification count on to_mark test
                // $test = new Tests_model();
                // $to_mark_count = $test->get_to_mark_count();
                $to_mark_count = (new Tests_model())->get_to_mark_count(); //notification answer test count
              ?>
              <?php if($to_mark_count): ?>
                <span class="badge bg-danger text-white" style="position: absolute; top: -4px; right:0px"><?=$to_mark_count?></span>
              <?php endif;?>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link <?=$this->controller_name() == 'Marked' ? 'active-nav' :''?>" href="<?=ROOT?>/marked">MARKED</a>
          </li>
        <?php endif;?>

        <!-- <li class="nav-item">
          <a class="nav-link" href="<?=ROOT?>/signup">SIGNUP</a>
        </li> -->
        
        </ul>
        <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-expanded="false">
            <?= Auth::getfirstname()?>
          </a>
          <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="<?=ROOT?>/profile">Profile</a></li>
            <li><a class="dropdown-item" href="<?=ROOT?>">Dashboard</a></li>
            <li><hr class="dropdown-divider"></li> 
            <li><a class="dropdown-item" href="<?=ROOT?>/logout">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

