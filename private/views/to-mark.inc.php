
<div class="card-group justify-content-center">

<div class="table-responsive container-fluid p-0">
    <table class="table table-striped table-hover">
        
    <tr>
        
    <?php if(Auth::access('lecturer')):?>
        <th>View Details</th>
        <?php endif;?>
        <th>Test Name</th> <th>Student</th> <th>Submitted Date</th> <th>Answer %</th> <th>Marked %</th> <th></th>
        
    </tr>

    <?php if(isset($test_rows) && $test_rows):?>
        <?php foreach($test_rows as $test_row):?>

            <tr>
                
            <?php if(Auth::access('lecturer')):?>
            <td>
                <a href="<?=ROOT?>/Mark_test/<?=$test_row->test_id?>/<?=$test_row->user->user_id?>">
                 <button class="btn btn-sm btn-primary"><i class="fa fa-chevron-right"></i>Mark Test</button>
                 </a>
            
            </td>
            <?php endif;?>
            <?php  //$active = $test_row->test_details->disabled ? "No":"Yes"; ?>
            <td><?=$test_row->test_details->test?></td> 
            <td><?=$test_row->user->firstname?>  <?=$test_row->user->lastname?> </td> 
            <td><?=get_date($test_row->submitted_date)?></td> 
        
          <td>
            <!-- disaplaying student answer % -->
                <?php
                
                    $percentage = get_answer_percentage($test_row->test_id, $test_row->user_id); 

                ?>
                    <?=$percentage?>%
          </td>

        <td>
            <?php $marked_percentage = get_mark_percentage($test_row->test_id, $test_row->user_id)?>
            <?=$marked_percentage?>%
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
        <tr><td colspan="6"><center>No tests were found at the moment</center></td></tr>
    <?php endif; ?> <br>

    </table>
</div>
</div>