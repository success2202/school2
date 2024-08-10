
<!-- Example single danger button -->
 <nav class="navbar">
  <center><h5>Test Questions</h5></center>
<div class="btn-group">
  <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="fa fa-bars"></i> Add Test
  </button>
  <ul class="dropdown-menu dropdown-menu-right">
    <li><a class="dropdown-item" href="<?=ROOT?>/single_test/testaddmultiple/<?=$row->test_id?>?tab=add-multiple">
        Add Multtiple choice Question</a></li>
    <li><a class="dropdown-item" href="<?=ROOT?>/single_test/testaddobjective/<?=$row->test_id?>?tab=add-objective">
        Add Objective Question</a></li>

    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item" href="<?=ROOT?>/single_test/addsubjective/<?=$row->test_id?>">
        Add Subjectiive Question</a></li>
  </ul>
</div>
</nav>
<hr>

<?php if(isset($questions) && is_array($questions)): ?>
  <?php $num = 0?>
<?php foreach($questions as $question): $num++?>   
    <div class="card mb-4 shadow">
      <div class="card-header">
       <span class="bg-secondary p-1 text-white rounded"> Question: #<?=$num?> </span> <span class="badge btn btn-secondary float-right"> <?=date("F jS, Y H:i:s a")?> </span>
      </div>
      <div class="card-body">
        <h5 class="card-title"><?=esc($question->question)?></h5>
        <p class="card-text"></p>
      <!-- </div>
      <div class="card-footer text-muted"> -->
        
      </div>
    </div>
<?php endforeach;?>
<?php endif;?>