<nav class="navbar navbar-light bg-light">
            <form class="container-inline">
                <div class="input-group">
                    <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i>&nbsp</span>
                    </div>
                   <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                </div>
            </form>    
           <a href="<?=ROOT?>/single_class/testadd/<?=$row->class_id?>?tab=tests-add">
          <button class="btn btn-sm btn-primary"><i class="fa fa-plus">&nbsp;&nbsp;Add New test</i></button>
        </a>
    </nav>

    <!-- displays the test on the test tab -->
    <table class="table table-striped table-hover">
    <tr><th>Details</th><th>Test</th> <th>Created By</th><th>Active</th><th>Taken</th><th>Date</th> <th>ACTION</th>
    <th>
   
    </th>
</tr>

    <?php if(isset($tests) && $tests):?>
        <?php foreach($tests as $row):?>

            <tr>
            <td>
                <a href="<?=ROOT?>/single_test/<?=$row->test_id?>">
                 <button class="btn btn-sm btn-primary"><i class="fa fa-chevron-right"></i></button>
                 </a>
            </td>
            <?php  $active = $row->disabled ? "No":"Yes"; ?>
            <td><?=$row->test?> </td> <td><?=$row->user->firstname?>  <?=$row->user->lastname?> </td> 
            <td><?=$active ?> </td> 
            <td><?=has_taken_test($row->test_id)?> </td>
            <td><?=get_date($row->date)?></td>
            <td>
                
            <?php if(Auth::access('lecturer')): ?>
                <a href="<?=ROOT?>/single_class/testedit/<?=$row->class_id?>/<?=$row->test_id?>?tab=tests">
                    <button class="btn-sm btn btn-info text-white"><i class="fa fa-edit"></i></button>
                </a>
                &nbsp;&nbsp;
                <a href="<?=ROOT?>/single_class/testdelete/<?=$row->class_id?>/<?=$row->test_id?>?tab=tests">
                    <button class="btn-sm btn btn-danger"><i class="fa fa-trash-alt"></i></button>
                </a>
           <?php endif;?>

            </td>
            <td></td>
            </tr>
        <?php endforeach; ?>

        <?php else:?>
        <tr><td colspan="6"><center>No tests were found at the moment</center></td></tr>
    <?php endif; ?> <br>

    </table>
