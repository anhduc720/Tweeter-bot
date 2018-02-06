<h1><?= $this->controller; ?></h1>
<hr>

<div class="container">
	 	<form action="<?= $this->general_model->site_url('index.php/campaigns/form_add_campaign'); ?>" id="form-add-campaign" method="post">

	 		<div id="message"></div>

	    <div class="form-group row">
	      <label for="name" class="col-sm-2 col-form-label">Name</label>
	      <div class="col-sm-10">
	        <input type="text" class="form-control" name="name" value="">
	      </div>
	    </div>

	    <div class="form-group row">
	      <label for="shipping_mode" class="col-sm-2 col-form-label">Shipping mode</label>
	      <div class="col-sm-10">
			<select name="shipping_mode" class="form-control">
				<option value="1">Normal</option>
				<option value="2">Random</option>
			</select>
	      </div>
	    </div>	    

	    <div class="form-group row">
	      <label for="account_id" class="col-sm-2 col-form-label">Account</label>
	      <div class="col-sm-10">
	        <?php $this->accounts_model->select_accounts($id_account); ?>
	      </div>
	    </div>


	    <div class="form-group row">
	      <label for="status" class="col-sm-2 col-form-label">Status</label>
	      <div class="col-sm-10">
			<select name="status" class="form-control">
				<option value="2">Active</option>
				<option value="1">Inactive</option>
			</select>
	      </div>
	    </div>

	    <div class="form-group row">
	      <label for="time_to_execute" class="col-sm-2 col-form-label">Time to execute</label>
	      <div class="col-sm-10">
			<input class="form-control" type="number" name="time_to_execute" aria-describedby="timeHelpBlock" value="10">
			<p id="timeHelpBlock" class="form-text text-muted">
				In minutes. For example 5 = every 5 minutes. 10 = every 10 minutes. etc.
			</p>
	      </div>
	    </div>

	    <div class="form-group row">
	      <label for="tweets" class="col-sm-2 col-form-label">Tweets</label>
	      <div class="col-sm-10">
			<textarea name="tweets" class="form-control" aria-describedby="tweetsHelpBlock"></textarea>
			<p id="tweetsHelpBlock" class="form-text text-muted">
				List of Tweets separated by line.
			</p>
	      </div>
	    </div>
	    <div class="form-group row">
	    	 <label for="" class="col-sm-2 col-form-label"></label>
	      <div class="col-sm-10">
	        <button type="submit" id="btnSubmit" class="btn btn-success form-control" aria-form="form-add-campaign">Create</button>
	      </div>
	    </div>

		</form>

	 </div>