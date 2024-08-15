
<div class="card-group justify-content-center">
<table class="table table-striped table-hover">
    <tr>
        
    <?php if(Auth::getRank() == 'lecturer'):?>
        <th>View Details</th>
        <?php endif;?>
        <th>Test Name</th> <th>Created by</th> <th>Active</th> <th>Date</th> 
        
    </tr>

    <?php if(isset($test_rows) && $test_rows):?>
        <?php foreach($test_rows as $test_row):?>

            <tr>
                
                <?php if(Auth::getRank() == 'lecturer'):?>
            <td>
                <a href="<?=ROOT?>/single_test/<?=$test_row->test_id?>">
                 <button class="btn btn-sm btn-primary"><i class="fa fa-chevron-right"></i></button>
                 </a>
            </td>
            <?php endif;?>

            <?php  $active = $test_row->disabled ? "No":"Yes"; ?>
            <td><?=$test_row->test?> <td><?=$test_row->user->firstname?>  <?=$test_row->user->lastname?> </td> <td><?=$active?></td> <td><?=get_date($test_row->date)?></td>
           
        <td>
            <?php if(can_take_test($test_row->test_id)):?>
            <a href="<?=ROOT?>/take_test/<?=$test_row->test_id?>">
                <button class="btn btn-sm btn-primary">Take this test</button>
            </a>
            <?php endif;?>
        </td>
            </tr>
        <?php endforeach; ?>

        <?php else:?>
        <tr><td colspan="5"><center>No tests were found at the moment</center></td></tr>
    <?php endif; ?> <br>

    </table>
</div>