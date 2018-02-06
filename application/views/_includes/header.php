<?php 
	$this->general_model->check_login();
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $this->general_model->title();?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php $this->general_model->css('bootstrap.css', TRUE); ?>
</head>
<body>
	<div class="container-fluid">
		<header>
			<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
			  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aia-label="Toggle navigation">
			    <span class="navbar-toggler-icon"></span>
			  </button>
			  <a class="navbar-brand" href="<?= $this->general_model->site_url('index.php'); ?>">Tweendo</a>

			  <div class="collapse navbar-collapse" id="navbarSupportedContent">
			    <ul class="navbar-nav mr-auto">
			      <li class="nav-item <?php $this->general_model->active_in_menu('Home'); ?>">
			        <a class="nav-link" href="<?= $this->general_model->site_url('index.php'); ?>">Home <span class="sr-only">(current)</span></a>
			      </li>

			      <li class="nav-item <?php $this->general_model->active_in_menu('Account'); ?>">
			        <a class="nav-link" href="<?= $this->general_model->site_url('index.php/accounts'); ?>">Accounts</a>
			      </li>
			      <li class="nav-item <?php $this->general_model->active_in_menu('Campaign'); ?>">
			        <a class="nav-link" href="<?= $this->general_model->site_url('index.php/campaigns'); ?>">Campaigns</a>
			      </li>
			      <?php
			      	if($this->session->userdata('logged_in')){ ?>
			      <li class="nav-item <?php echo $this->controller == 'Logout' ? 'active' : ''; ?>">
			        <a class="nav-link" href="<?= $this->general_model->site_url('index.php/login/logout'); ?>">Logout</a>
			      </li>

			      <?php } ?>
			    </ul>	
			  </div>

			</nav>

		</header>
	</div>
	<br>

	<section id="template">
		<div class="container">
			<div class="jumbotron text-center">

