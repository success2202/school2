<?php $this->view('includes/header')?>
<?php $this->view('includes/nav')?>

    <div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px;">
    <?php $this->view('includes/crumbs',['crumbs'=>$crumbs])?>

    <?php if($row): ?>

    <div class="row">
        <center> <h5><?=esc(ucwords($row->class))?></h5> </center>

            <table class="table table-hover table-striped table-bordered">
            
                <tr><th>Created by:</th><td><?=esc($row->user->firstname)?> <?=esc($row->user->lastname)?></td>
                <th>Date Created:</th><td><?=get_date($row->date)?></td></tr>
            </table>
       
    </div>
    
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?=$page_tab=='lecturers'?'active':'';?>" href="<?=ROOT?>/single_class/<?=$row->class_id?>?tab=lecturers">lecturers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?=$page_tab=='students'?'active':'';?>" href="<?=ROOT?>/single_class/<?=$row->class_id?>?tab=students">students</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?=$page_tab=='tests'?'active':'';?>" href="<?=ROOT?>/single_class/<?=$row->class_id?>?tab=tests">Test</a>
            </li>
            
        </ul>
    
    <?php
        switch ($page_tab) {
            case 'lecturers':
                include(views_path('class-tab-lecturers'));
                break;
            case 'students':
                include(views_path('class-tab-students'));
                 break;
            case 'tests':
                include(views_path('class-tab-tests'));
                 break;
            case 'tests-add':
                include(views_path('class-tab-tests-add'));
                 break;
            case 'tests-edit':
                include(views_path('class-tab-tests-edit'));
                  break;
            case 'tests-delete':
                include(views_path('class-tab-tests-delete'));
                    break;
            case 'lecturers-add':
                include(views_path('class-tab-lecturers-add'));
                break;
            case 'lecturers-remove':
                include(views_path('class-tab-lecturers-remove'));
                break;

            case 'students-remove':
                include(views_path('class-tab-students-remove'));
                break;

            case 'students-add':
                include(views_path('class-tab-students-add'));
                 break;
            case 'tests-add':
                include(views_path('class-tab-tests-add'));
                 break;
            
            default:
                # code...
                break;
        }

        ?>

    <?php else: ?>
        <h4 style="text-align:center;"> the class was not found</h4>
    <?php endif; ?>
    </div>
    <?php $this->view('includes/footer')?>