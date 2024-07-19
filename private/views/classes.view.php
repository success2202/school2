<?php $this->view('includes/header')?>
<?php $this->view('includes/nav')?>

<div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px;">
<?php $this->view('includes/crumbs',['crumbs'=>$crumbs])?>

<div class="card-group justify-content-center">
<h5>Classes</h5>
<table class="table table-striped table-hover">
    <tr><th>Details</th><th>Class Name</th> <th>Created by</th><th>Date</th>
    <th>
        <a href="<?=ROOT?>/classes/add">
        <button class="btn-sm btn btn-primary"><i class="fa fa-plus">&nbsp;&nbsp;Add New</i></button>
        </a>
    </th>
</tr>


    <?php if($rows):?>
        <?php foreach($rows as $row):?>

            <tr>
            <td><button class="btn btn-sm btn-primary"><i class="fa fa-chevron-right"></i></button></td>
            <td><?=$row->school?></td><td><?=$row->user->firstname?>  <?=$row->user->lastname?></td><td><?=get_date($row->date)?></td>
            <td>
            <a href="<?=ROOT?>/classes/edit/<?=$row->user->id?>">
                <button class="btn-sm btn btn-info text-white"><i class="fa fa-edit"></i></button>
            </a>
            &nbsp;&nbsp;
            <a href="<?=ROOT?>/classes/delete/<?=$row->user->id?>">
                <button class="btn-sm btn btn-danger"><i class="fa fa-trash-alt"></i></button>
            </a>

            </td>
            </tr>
        <?php endforeach; ?>
    <?php else:?>
        <h4>No Schools were found at the moment</h4>
    <?php endif; ?>
</table>
</div>
    </div>
    
   



    <?php $this->view('includes/footer')?>