<?php 
	
	if(count($campaign) === 0){
		$this->general_model->redirect($this->general_model->site_url('index.php/campaigns'));
	}

	$campaign = $campaign[0];

	(int) $id      = $campaign['id'];
	$name          = $campaign['name'];
	$shipping_mode = $campaign['shipping_mode'];
	$status        = $campaign['status'];
	$account_id    = $campaign['account_id'];
	$time_to_exec  = $campaign['time_to_execute'] / 60;
	$errors        = $campaign['num_errors'];


 ?>

 <h1><?= $this->controller.' <b>'.$campaign['name'].'</b>'; ?></h1>
<hr>

<div class="container">
	 	<form action="<?= $this->general_model->site_url('index.php/campaigns/form_update_campaign'); ?>" id="form-update-campaign" method="post">

	 		<div id="message"></div>

	    <div class="form-group row">
	      <label for="name" class="col-sm-2 col-form-label">Name</label>
	      <div class="col-sm-10">
	      	<input type="hidden" name="id" value="<?= $id ?>">
	        <input type="text" class="form-control" name="name" value="<?= $name; ?>">
	      </div>
	    </div>

	    <div class="form-group row">
	      <label for="shipping_mode" class="col-sm-2 col-form-label">Shipping mode</label>
	      <div class="col-sm-10">
			<select name="shipping_mode" class="form-control">
				<option value="1" <?php echo $shipping_mode == 1 ? 'selected' : ''; ?> >Normal</option>
				<option value="2" <?php echo $shipping_mode == 2 ? 'selected' : ''; ?> >Random</option>
			</select>
	      </div>
	    </div>	    

	    <div class="form-group row">
	      <label for="account_id" class="col-sm-2 col-form-label">Account</label>
	      <div class="col-sm-10">
	        <?php $this->accounts_model->select_accounts($account_id); ?>
	      </div>
	    </div>


	    <div class="form-group row">
	      <label for="status" class="col-sm-2 col-form-label">Status</label>
	      <div class="col-sm-10">
			<select name="status" class="form-control">
				<option value="2" <?php echo $status == 2 ? 'selected' : ''; ?> >Active</option>
				<option value="1" <?php echo $status == 1 ? 'selected' : ''; ?> >Inactive</option>
			</select>
	      </div>
	    </div>

	    <div class="form-group row">
	      <label for="time_to_execute" class="col-sm-2 col-form-label">Time to execute</label>
	      <div class="col-sm-10">
			<input class="form-control" type="number" name="time_to_execute" aria-describedby="timeHelpBlock" value="<?= $time_to_exec; ?>">
			<p id="timeHelpBlock" class="form-text text-muted">
				In minutes. For example 5 = every 5 minutes. 10 = every 10 minutes. etc.
			</p>
	      </div>
	    </div>

	    <div class="form-group row">
	    	 <label for="" class="col-sm-2 col-form-label"></label>
	      <div class="col-sm-10">
	        <button type="submit" id="btnSubmit" class="btn btn-success form-control" aria-form="form-update-campaign">Save</button>
	      </div>
	    </div>

		</form>

	 </div>