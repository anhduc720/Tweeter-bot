<?php 

	class Recovery extends CI_Controller {
		public $controller = "Recovery";
		public function __construct(){
			parent::__construct();
		}

		public function index(){
			$this->load->view('sections/login/recovery');
		}
		public function recovery(){
			if(!$_POST){ die;}

			$admin = $this->general_model->get_settings()[0];

			if($admin['email_admin'] != $_POST['email']){
				echo '<p>Wrong Email...</p>';
				die;
			}

			$password = $admin['password'] == 'admin' ? 'admin' : base64_decode($admin['password']);

			$message = 'A request for password reset has been received, the data is as follows:';
			$message .= '<p>Username: '.$admin['username'].'</p>';
			$message .= '<p>Password: '.$password.'</p>';
			$message .= '<p><a href="'.$this->general_model->site_url('index.php/login').'">Login now</a></p>';
			$message .= '<p>If it was not you, please check your script and update your password if necessary.</p>';

			$this->load->model('email_model');
			if($this->email_model->recovery_password($message)){
				echo '<p>The email with your password has been sent</p>';
				die;
			} else {
				echo '<p>There was an error sending your email with your data ... try again</p>';
				die;
			}
		}
	}