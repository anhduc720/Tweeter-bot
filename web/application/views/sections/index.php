<?php 
	if(count($settings) == 0){
		echo 'No data settings...'; die;
	}


 ?>

 <h1><?= $this->config->item('platform');?> - Settings</h1>

	 <div class="container">
	 	<form action="<?= $this->general_model->site_url('index.php/index/update_settings'); ?>" id="form-settings">

	 		<div id="message"></div>

	    <div class="form-group row">
	      <label for="name_admin" class="col-sm-2 col-form-label">Name</label>
	      <div class="col-sm-10">
	        <input type="text" class="form-control" name="name_admin" value="<?= $settings[0]['name_admin'];?>">
	      </div>
	    </div>

	    <div class="form-group row">
	      <label for="email_admin" class="col-sm-2 col-form-label">Email</label>
	      <div class="col-sm-10">
	        <input type="email" class="form-control" name="email_admin" value="<?= $settings[0]['email_admin'];?>">
	      </div>
	    </div>

	    <div class="form-group row">
	      <label for="username" class="col-sm-2 col-form-label">Username</label>
	      <div class="col-sm-10">
	        <input type="text" class="form-control" name="username" value="<?= $settings[0]['username'];?>">
	      </div>
	    </div>

	    <div class="form-group row">
	      <label for="allowed_errors" class="col-sm-2 col-form-label">Allowed errors</label>
	      <div class="col-sm-10">
	        <input type="number" class="form-control" name="allowed_errors" value="<?= $settings[0]['allowed_errors'];?>">
	      </div>
	    </div>

	    <div class="form-group row">
	      <label for="name_admin" class="col-sm-2 col-form-label">Timezone</label>
	      <div class="col-sm-10">
	        <select name="timezone" id="" class="form-control">
	     <?php
	     $timezones = $this->general_model->timezones();
			foreach($timezones as $region => $list){
				echo '<optgroup label="' . $region . '">'.PHP_EOL;
				foreach($list as $timezone => $name)
				{ ?>
					<option <?php echo $settings[0]['timezone'] == $timezone ? 'selected="selected"' : ''; ?>  value="<?= $timezone;?>"><?= $name;?></option>';
				<?php }
				echo '<optgroup>'.PHP_EOL;
			}
?>
	        </select>
	      </div>
	    </div>

	    <div class="form-group row">
	    	 <label for="" class="col-sm-2 col-form-label"></label>
	      <div class="col-sm-10">
	        <button type="submit" id="btnSubmit" class="btn btn-success form-control" aria-form="form-settings">Update</button>
	      </div>
	    </div>

		</form>

	 </div>

	<hr> <br>
	 <div class="container">
	 	<h1>Change Password</h1>

	 	<form action="<?= $this->general_model->site_url('index.php/index/change_password');?>" id="form-change-password">
	 		<div id="message"></div>

		    <div class="form-group row">
		      <label for="old_password" class="col-sm-2 col-form-label">Old password</label>
		      <div class="col-sm-10">
		        <input type="password" class="form-control" name="old_password">
		      </div>
		    </div>

		    <div class="form-group row">
		      <label for="new_password" class="col-sm-2 col-form-label">New password</label>
		      <div class="col-sm-10">
		        <input type="password" class="form-control" name="new_password">
		      </div>
		    </div>

		    <div class="form-group row">
		      <label for="retype_password" class="col-sm-2 col-form-label">Retype password</label>
		      <div class="col-sm-10">
		        <input type="password" class="form-control" name="retype_password">
		      </div>
		    </div>

	    <div class="form-group row">
	    	 <label for="" class="col-sm-2 col-form-label"></label>
	      <div class="col-sm-10">
	        <button type="submit" id="btnSubmit" class="btn btn-success form-control" aria-form="form-change-password">Update password</button>
	      </div>
	    </div>
	 	</form>
	 </div>

 