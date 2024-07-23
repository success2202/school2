<?php  

      $image = get_image($row->image, $row->gender); 
    ?>
    
        <div class="card m-1 shadow-sm" style="max-width: 14rem; min-width: 14rem;">
        <!-- <div class="card-header">User Profile</div> -->
        <img src="<?=$image?>" class="card-img-top" alt="card image cap">
        
        <div class="card-body">
        <h5 class="card-title"><?=$row->firstname?> <?=$row->lastname?></h5>
        <p class="card-text"><?=str_replace("_"," ",$row->rank)?></p>
        <a href="<?=ROOT?>/profile/<?=$row->user_id?>" class="btn btn-primary">Profile</a>
       
       <?php if(isset($_GET['select'])):?>
         <button name="selected" value="<?=$row->user_id?>" class="btn btn-danger float-right"> Select </button>
        <?php endif;?>
      </div>
</div>
