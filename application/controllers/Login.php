<?php 


	class Login extends CI_Controller {
		public $controller = "Login";

		public function __construct(){
			parent::__construct();
		}

		public function index(){
			$this->load->view('sections/login/login');
		}

		public function login(){
			if(!$_POST){die;}
			$this->general_model->sanitize_post($_POST);

			$admin = $this->general_model->get_settings()[0];
			$username = $admin['username'];
			$password = $admin['password'] == 'admin' ? $admin['password'] : base64_decode($admin['password']);

			if($username != $_POST['username']){
				echo "<p>wrong username...</p>";
				die;
			} 

			if($password != $_POST['password']){
				echo "<p>wrong password...</p>";
				die;
			}

			echo '<p>Session started... please wait...</p>';

			$this->session->set_userdata('logged_in', TRUE);
			$url_redirect = $this->session->userdata('url_redirect') ? $this->session->userdata('url_redirect') : $this->general_model->site_url();

			$this->session->unset_userdata('url_redirect');

			$this->general_model->redirect($url_redirect, 3000);
		}

		public function logout(){
			$this->controller = "Logout"; ?>
			<!DOCTYPE html>
			<html>
			<head>
				<meta charset="utf-8">
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<title><?= $this->general_model->title(); ?></title>
				<link rel="stylesheet" href="">
			</head>
			</html>
			<?php 
			$this->session->sess_destroy();
			$this->general_model->redirect($this->general_model->site_url('index.php/login', 100));
		}

	} //end class Login