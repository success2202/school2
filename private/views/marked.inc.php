
<div class="card-group justify-content-center">

<div class="table-responsive container-fluid p-0">
    <table class="table table-striped table-hover">
    <tr>
        
        <th></th>
        <th>Test Name</th> <th>Student</th> <th>Date Submitted</th> <th>Marked By</th> 
        <th>Marked Date</th> <th>Answer</th> <th>Score</th> 
        <?php 
        if(Auth::getRank()=='student'):?><th>Action</th>
         <?php else:?>
            <td></td>
         <?php endif;?>
        
    </tr>

    <?php if(isset($test_rows) && $test_rows):?>
        <?php foreach($test_rows as $test_row):?>

            <tr>
                
           
          
            <td></td>
           
            <?php  $active = $test_row->test_details->disabled ? "No":"Yes"; ?>
            <td><?=$test_row->test_details->test?></td> 
            <td><?=$test_row->user->firstname?>  <?=$test_row->user->lastname?> </td> 
            <td><?=get_date($test_row->submitted_date)?></td> 
            
            
            <td>
                <?php
                $user = new User();
                $test_marker = $user->first('user_id',$test_row->marked_by);
                echo $test_marker->firstname . ' ' . $test_marker->lastname;
                ?>
            </td> 
            
            
            <td><?=get_date($test_row->marked_date)?></td> 
        
          <td>
            <!-- disaplaying student answer % -->
                <?php
                
                    $percentage = get_answer_percentage($test_row->test_id, $test_row->user_id); 

                ?>
                    <?=$percentage?>%
          </td>  

          <td>
            <!-- disaplaying student score % -->
                <?=get_score_percentage($test_row->test_details->test_id,$test_row->user->user_id);?>%
                    
          </td>  

        <td>
                <a href="<?=ROOT?>/marked_singleTest/<?=$test_row->test_id?>/<?=$test_row->user->user_id?>">
                 <button class="btn btn-sm btn-primary"><i class="fa fa-chevron-right"></i>View</button>
                 </a>
        </td>
            </tr>
        <?php endforeach; ?>

        <?php else:?>
        <tr><td colspan="10"><center>No tests were found at the moment</center></td></tr>
    <?php endif; ?> <br>

    </table>
</div>
</div>