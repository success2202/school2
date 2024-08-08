<?php $this->view('includes/header')?>
<?php $this->view('includes/nav')?>

    <div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px;">
    <?php $this->view('includes/crumbs',['crumbs'=>$crumbs])?>

    <?php if($row): ?>

    <div class="row">
        
        <center>
        <h4><?=esc(ucwords($row->test))?></h4>
        </center>
        
            <table class="table table-hover table-striped table-bordered">
            
                <tr><th>Created by:</th><td><?=esc($row->user->firstname)?> <?=esc($row->user->lastname)?></td>
                <th>Date Created:</th><td><?=get_date($row->date)?></td></tr>
            </table>
       
    </div>
    
    <?php
        switch ($page_tab) {
            case 'view':
                include(views_path('test-tab-view'));
                break;
            case 'add':
                include(views_path('test-tab-add'));
                 break;
            case 'edit':
                include(views_path('test-tab-edit'));
                 break;
            case 'delete':
                include(views_path('test-tab-delete'));
                 break;
            
            
            default:
                # code...
                break;
        }

        ?>

    <?php else: ?>
        <h4 style="text-align:center;"> the test was not found</h4>
    <?php endif; ?>
    </div>
    <?php $this->view('includes/footer')?>