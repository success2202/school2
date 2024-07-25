<?php $this->view('includes/header')?>
<?php $this->view('includes/nav')?>

<div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px;">
<?php $this->view('includes/crumbs',['crumbs'=>$crumbs])?>

    <h5 class="card-group justify-content-center">Classes</h5>

    <!-- including a class table view on the class -->
            <?php include(views_path('classes')); ?> 
    </div>
    
    <?php $this->view('includes/footer')?>