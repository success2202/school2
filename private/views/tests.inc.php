
<div class="card-group justify-content-center">

<div class="table-responsive container-fluid p-0">
    <table class="table table-striped table-hover">
    <tr>
    <?php if(Auth::access('lecturer')):?> 
    <th></th> 
    <?php endif;?>
    <th>Test Name</th> <th>Created by</th> <th>Active</th> <th>Date</th> <th>Answer %</th><th></th>
        
    </tr>

    <?php if(isset($test_rows) && $test_rows):?>
        <?php foreach($test_rows as $test_row):?>

            <tr>
                
            <?php if(Auth::access('lecturer')):?>  
            <td>
            
                <a href="<?=ROOT?>/single_test/<?=$test_row->test_id?>">
                 <button class="btn btn-sm btn-primary"><i class="fa fa-chevron-right"></i></button>
                 </a>
            
            </td>
            <?php endif;?>
            <?php  $active = $test_row->disabled ? "No":"Yes"; ?>
            <td><?=$test_row->test?></td> <td><?=$test_row->user->firstname?>  <?=$test_row->user->lastname?> </td> <td><?=$active?></td> <td><?=get_date($test_row->date)?></td> 
        
          <td>
            <!-- disaplaying student answer % -->
                <?php
                //getting the current user or other users in the admin user page 
                    $myid = get_class($this) == "Profile" ? $row->user_id : Auth::getUser_id();
                    $percentage = get_answer_percentage($test_row->test_id, $myid); 

                ?>
                    <?=$percentage?>%
          </td>  

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
        <tr><td colspan="10"><center>No tests were found at the moment</center></td></tr>
    <?php endif; ?> <br>

    </table>
</div>
</div>