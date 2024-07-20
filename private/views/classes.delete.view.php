<?php $this->view('includes/header')?>
<?php $this->view('includes/nav')?>

<div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px;">
<?php $this->view('includes/crumbs',['crumbs'=>$crumbs])?>

<?php if($row):?>
   
<div class="card-group justify-content-center">
 

<form method="post">

    <h3>are you sure you want to delete </h3>

    <input disabled autofocus class="form-control" type="text" value="<?=get_var('class', $row[0]->class)?>" name="class" placeholder="Class Name"> <br>
    <input type="hidden" name="id">
    <input class="btn btn-danger float-right" type="submit" value="Delete">
    
    <a href="<?=ROOT?>/classes">
        <input class="btn btn-success text-white" type="button" value="Cancel">
    </a>
</form>

  </div>
<?php else: ?>
    <div style="text-align: center;">
   <h3>that class  was not Found</h3>
   
   <a href="<?=ROOT?>/classes">
        <input class="btn btn-danger text-white" type="button" value="Cancel">
    </a>
</div>
<?php endif; ?>


    </div> 
    

    <?php $this->view('includes/footer')?>