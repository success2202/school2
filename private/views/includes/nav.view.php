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


</style>
<nav class="navbar navbar-expand-lg navbar-light bg-light p-2">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
    <img src="<?=ROOT?>/assets/logo1.png" class="" style="width: 70px" alt="">
        My School</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="<?=ROOT?>">DASHBOARD</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?=ROOT?>/users">USERS</a>
        </li>  
        <li class="nav-item">
          <a class="nav-link" href="<?=ROOT?>/classes">CLASSES</a>
        </li>  
        
        <li class="nav-item">
          <a class="nav-link" href="<?=ROOT?>/test">TESTS</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="<?=ROOT?>/signup">SIGNUP</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?=ROOT?>/login">LOGIN</a>
        </li>
        </ul>
        <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-expanded="false">
            USER
          </a>
          <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="<?=ROOT?>/profile">Profile</a></li>
            <li><a class="dropdown-item" href="<?=ROOT?>">Dashboard</a></li>
            <li><hr class="dropdown-divider"></li> 
            <li><a class="dropdown-item" href="<?=ROOT?>">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>