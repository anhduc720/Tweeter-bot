
      <h1>Accounts</h1>
        <h4><a id="btn-authorization" class="btn btn-success btn-lg" aria-url="<?=$this->general_model->site_url('index.php/accounts/url_authorization'); ?>" href="">Add Account</a></h4>
      <hr>
      <br>
      <div class="row">
    	<?php if($number_accounts > 0){ 
    		foreach ($accounts as $account) {
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
            <a href="https://twitter.com/<?= $account['screen_name']; ?>"><img src="<?= $account['profile_image_url'] ?>" alt="" class="img-responsive rounded-circle py-3"></a>
            <h3 id="<?= $account['screen_name'];?>"><?= $account['screen_name']; ?></h3>
            <p><strong>Statuses:</strong> <span class="bg-primary py-2 px-2 rounded-circle" style="color: white;"> <?= $account['statuses_count'];?></span></p>

            <p><strong>Followers:</strong> <span class="bg-primary py-2 px-2 rounded-circle" style="color: white;"> <?= $account['followers_count'];?></span></p>

            <p><strong>Following:</strong> <span class="bg-primary py-2 px-2 rounded-circle" style="color: white;"> <?= $account['friends_count'];?></span></p>

            <p><strong>Favourites</strong> <span class="bg-primary py-2 px-2 rounded-circle" style="color: white;"> <?= $account['favourites_count'];?></span></p>

            <p></p>
          </div>

          <div class="row mx-auto">
            <p class="col-lg-3  col-12"><a class="btn btn-info btn-lg" href="<?= $this->general_model->site_url('index.php/accounts/send_tweet/'.$account['id']);?>">Send Tweet</a></p>
            <p class="col-lg-3  col-12"><a class="btn btn-success btn-lg" id="btn-update" aria-url="<?=$this->general_model->site_url('index.php/accounts/update_account');?>" aria-id="<?= $account['id'];?>"  href="">Update</a></p>
            <p class="col-lg-3  col-12"><a class="btn btn-warning btn-lg" href="<?= $this->general_model->site_url('index.php/campaigns/add_campaign/'.$account['id']); ?>">Campaign</a></p>
            <p class="col-lg-3  col-12"><a class="btn btn-danger btn-lg" id="btnDelete" aria-id="<?= $account['id'];?>" aria-action="<?= $this->general_model->site_url('index.php/accounts/delete_account');?>" href="">Delete</a></p>
            
          </div>

          </div>
      </div>


      <?php } 
      if($total_pages > 1){
          $url = $this->general_model->site_url('index.php/accounts/index/');
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
