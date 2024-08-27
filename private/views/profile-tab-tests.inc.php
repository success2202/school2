
<h3> tests </h3>
<nav class="navbar navbar-light bg-light">
            <form class="form-inline">
                <div class="input-group">
                    <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i>&nbsp</span>
                </div>
                <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
               </div>
            </form>
        </nav>

        <?php if($row->rank == 'student'):?>
            <?php include(views_path('marked')); ?> 
        <?php else:?>
            <?php include(views_path('tests')); ?>
        <?php endif;?>