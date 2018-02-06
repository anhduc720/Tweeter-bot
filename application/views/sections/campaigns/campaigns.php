


  <h1>Campaigns</h1>
  <h4><a class="btn btn-success btn-lg" href="<?= $this->general_model->site_url('index.php/campaigns/add_campaign') ?>">Add Campaign</a></h4>
  <hr>
  <br>
  <div class="row">
	<?php if($number_campaigns > 0){ 
		foreach ($campaigns as $campaign) {
      $shipping_mode = $campaign['shipping_mode'] === 1 ? 'Normal' : 'Random';
      $status        = $campaign['status'] === 1 ? 'Inactive' : 'Active';
      
		?>

<style>
.shading:hover{
  box-shadow: 2px 3px 3px black;
}

/* Sombra interna */

.shading:hover{
box-shadow: 2px 2px 4px black inset,
            -2px -2px 4px black inset;
-webkit-transition-duration: 0.2s;
}

</style>




  <div class="card col-12 bg-faded mb-3 py-4 shading">
    <div class="row">
      
        
      <div class="col-sm-12">
        <h3><?= $campaign['name']; ?></h3>
        <p><strong>Shipping mode:</strong> <span class="bg-primary py-2 px-2 rounded-circle" style="color: white;"> <?= $shipping_mode;?></span></p>

        <p><strong>Status:</strong> <span class="bg-primary py-2 px-2 rounded-circle" style="color: white;"> <?= $status;?></span></p>

        <p><strong>Errors:</strong> <span class="bg-primary py-2 px-2 rounded-circle" style="color: white;"> <?= $campaign['num_errors'];?></span></p>

        <p><strong>Time to execute</strong> <span class="bg-primary py-2 px-2 rounded-circle" style="color: white;"> <?= $campaign['time_to_execute'];?></span></p>

        <p></p>
      </div>

      <div class="row mx-auto">
        <p class="col-lg-4  col-12"><a class="btn btn-success btn-lg" href="<?= $this->general_model->site_url('index.php/campaigns/update_campaign/'.$campaign['id']); ?>">Update</a></p>
        <p class="col-lg-4  col-12"><a class="btn btn-warning btn-lg" href="">Execute now</a></p>
        <p class="col-lg-4  col-12"><a class="btn btn-danger btn-lg" id="btnDelete" aria-id="<?= $campaign['id'];?>" aria-action="<?= $this->general_model->site_url('index.php/campaigns/delete_campaign');?>" href="">Delete</a></p>
        
      </div>

      </div>
  </div>


  <?php } 
if($total_pages > 1){
      $url = $this->general_model->site_url('index.php/campaigns/index/');
      $next = $page >= $total_pages ? $total_pages : $page + 1;
      $previous = $page <= 1 ? 1 : $page - 1;
  ?>
    <div id="pagination">
        <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center">
        <li class="page-item <?php echo $page == 1 ? 'disabled' : '';?>">
          <a class="page-link" href="<?php echo $url.$previous;?>" tabindex="-1">Previous</a>
        </li>
          <?php 

            for ($i=$page+1; $i <= $total_pages ; $i++) { 
              echo '<li class="page-item"><a class="page-link" href="'.$url.$i.'">'.$i.'</a></li>';
            }
          ?>
        <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : '';?>">
          <a class="page-link " href="<?php echo $url.$next;?>">Next</a>
        </li>
      </ul>
    </nav>
  </div>
 <?php
      }
    } else {
  echo "No data";
  } ?> 
  </div>
