<?php 

	class Index extends CI_Controller {
		public $controller = 'Home';
	

	public function __construct(){
		parent::__construct();

		
	}

	public function index(){
		$data['settings'] = $this->general_model->get_settings();
		$this->general_model->template('index', $data);
		
	}

	public function update_settings(){
		if(!$_POST){die;}
		$this->general_model->sanitize_post($_POST);
		if($this->general_model->update_settings($_POST)){
			echo '<p class="alert alert-success">Updated successfully!</p>';
		} else{
			echo '<p class="alert alert-danger">Could not update... Try again.</p>';
		}
	}

	public function change_password(){
		if(!$_POST){die;}
		$password = $this->general_model->sanitize_post($_POST)->change_password($_POST);

		$message = $password ? 'Password updated successfully' : 'Could not update... Try again';
		$class   = $password ? 'alert-success' : 'alert-danger';

		echo '<p class="alert '.$class.'">'.$message.'</p>';

		return;
	}

}//END CLASS
 ?>