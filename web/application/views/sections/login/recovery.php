<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html lang="en">

<head>
	<title><?= $this->general_model->title();?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta charset="utf-8">
	<?= $this->general_model->css('font-awesome.min.css', TRUE);?>
	<?= $this->general_model->css('login.css', TRUE); ?>
	<link href="//fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">

	<?= $this->general_model->js('jquery.js', TRUE); ?>
	<?= $this->general_model->js('main.js', TRUE); ?>
</head>

<body>
	<h1 class="header-w3ls"> <?= $this->config->item('platform');?> | Login</h1>
	<div class="appointment-w3">

		<form action="<?= $this->general_model->site_url('index.php/recovery/recovery') ?>" method="post" id="form-login">
			
			<h2 class="sub-heading-wthree"> Login Here</h2>
			<div class="main">
				<div id="message" class="txt-center">
					
				</div>
				<div class="clear">
					<hr>
				</div>
				<div class="form-left-w3l">
					<input type="email" name="email" placeholder="email" required="">
				</div>
				<a href="<?= $this->general_model->site_url('index.php/login'); ?>" class="for">Login now</a>
				<div class="clear"></div>
			</div>
			<div class="btnn">
				<button type="submit" id="btnSubmit" aria-form="form-login">Recovery</button><br>
				<div class="clear"></div>
			</div>

		</form>
	</div>

	<div class="copy">
		<p>&copy;<?= $this->config->item('platform') . ' | ' . $this->config->item('platform_description'); ?></p>
	</div>

</body>

</html>