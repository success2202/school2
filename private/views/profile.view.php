<?php $this->view('includes/header')?>
<?php $this->view('includes/nav')?>

    <div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px;">
    <?php $this->view('includes/crumbs')?>
    <div class="row">
        <div class="col-sm-4 col-md-3">
        <img src="<?=ROOT?>/assets/user.png" class=" bg-light d-block border border-light mx-auto rounded-circle" style="width: 150px" alt="">
        <h3 class="text-center">Mary Mike</h3>
    </div>
        <div class="col-sm-9 col-md-8 bg-light p-2">
            <table class="table table-hover table-striped table-bordered">
                <tr><th>First Name:</th><td>Mary</td></tr>
                <tr><th>Last Name:</th><td>Mike</td></tr>
                <tr><th>Gender:</th><td>Male</td></tr>
                <tr><th>Date Created:</th><td>30-06-2024</td></tr>
            </table>
        </div>
    </div>
    <br>
    <div class="container-fluid">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Basic Info</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Classes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Test</a>
            </li>
            
        </ul>
                <nav class="navbar navbar-light bg-light">
            <form class="container-inline">
                <div class="input-group">
                    <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i>&nbsp</span>
                </div>
                <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                
            </form>
            </nav>
    </div>
    </div>
    <?php $this->view('includes/footer')?>