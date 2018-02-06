<?php 

	if(count($account) > 0){ ?>
		<h1><?= $this->controller; ?> whit <?= $account[0]['screen_name']; ?></h1>
		<hr><br>
		<div class="container">
	 	<form action="<?= $this->general_model->site_url('index.php/accounts/send_tweet'); ?>" id="form-send-tweet">

	 		<div id="message"></div>

	    <div class="form-group row">
	      <label for="tweet" class="col-sm-2 col-form-label">Tweet</label>
	      <div class="col-sm-10">
			<textarea name="tweet" id="tweet" class="form-control">
			</textarea>
	    </div>
	</div>

	<input type="hidden" name="id" value="<?= $account[0]['id']; ?>">
	<input type="hidden" name="screen_name" value="<?= $account[0]['screen_name']; ?>">
	    <div class="form-group row">
	    	 <label for="" class="col-sm-2 col-form-label"></label>
	      <div class="col-sm-10">
	        <button type="submit" id="btnSubmit" class="btn btn-success form-control" aria-form="form-send-tweet">Send</button>
	      </div>
	    </div>

		</form>

	 </div>
	<?php } else {
		echo "No data...";
	}
 ?>