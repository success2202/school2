
<div class="card-group justify-content-center">

<div class="table-responsive conainer-fluid p-0">
    <table class="table table-striped table-hover">
     <tr><th>Details</th><th>Class Name</th> <th>Created by</th><th>Date</th>
     <?php if(Auth::access('lecturer')): ?> <th>ACTION</th> <?php else:?>
        <th>
    
        </th>
        <?php endif;?>
     </tr>

    <?php if(isset($rows) && $rows):?>
        <?php foreach($rows as $row):?>

            <tr>
            <td>
                <a href="<?=ROOT?>/single_class/<?=$row->class_id?>?tab=students">
                 <button class="btn btn-sm btn-primary"><i class="fa fa-chevron-right"></i></button>
                 </a>
            </td>
            
            <td><?=$row->class?> <td><?=$row->user->firstname?>  <?=$row->user->lastname?> </td><td><?=get_date($row->date)?></td>
            <td>
                
            <?php if(Auth::access('lecturer')): ?>
                <a href="<?=ROOT?>/classes/edit/<?=$row->id?>">
                    <button class="btn-sm btn btn-info text-white"><i class="fa fa-edit"></i></button>
                </a>
                &nbsp;&nbsp;
                <a href="<?=ROOT?>/classes/delete/<?=$row->id?>">
                    <button class="btn-sm btn btn-danger"><i class="fa fa-trash-alt"></i></button>
                </a>
           <?php endif;?>

            </td>
            </tr>
        <?php endforeach; ?>

        <?php else:?>
        <tr><td colspan="5"><center>No classes were found at the moment</center></td></tr>
    <?php endif; ?> <br>

    </table>
</div>
</div>