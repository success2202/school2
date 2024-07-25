
<h3> My classes </h3>
<nav class="navbar navbar-light bg-light">
            <form class="container-inline">
                <div class="input-group">
                    <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i>&nbsp</span>
                </div>
                <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                
            </form>
            </nav>
 <!-- including a class table view  on the class profile-->
 <?php $rows = $student_classes;?>

 <?php include(views_path('classes')); ?>



 