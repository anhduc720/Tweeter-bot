<?php 

	class Accounts extends CI_Controller {
		public $controller = 'Accounts';

		public function __construct(){
			parent::__construct();
		}

		public function url_authorization(){
		 if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest'){
		 	die();
		 }
			$this->load->model('twitteroauth_model');
			$this->twitteroauth_model->url_authorization();
		}

		//Views
		public function index($page = 1){
			$page_size               = 5;
			$max_pages               = 10;
			$start                   = ($page-1) * $page_size;
			$number_accounts         = $this->general_model->count_accounts();
			$total_pages             = ceil($number_accounts / $page_size);
			$data['page']            = $page;
			$data['accounts']         = $this->general_model->get_data_for_pagination('accounts',$start,$page_size);
			$data['page_size']       = $page_size;
			$data['max_pages']       = $max_pages;
			$data['start']           = $start;
			$data['number_accounts'] = $number_accounts;
			$data['total_pages']     = $total_pages;

			$this->general_model->template('accounts/accounts', $data);
		}

		public function send_tweet($id = null){
			if(!$_POST){
			$this->controller = "Send Tweet Accounts";
			$data['account'] = $this->general_model->get_data_by_id('accounts', $id);
			$this->general_model->template('accounts/send-tweet', $data);
			} else {
				$this->general_model->sanitize_post($_POST);
				$this->load->model('twitteroauth_model');
				$tweet = $this->twitteroauth_model->send_simple_tweet($_POST['id'], $_POST['tweet']);
				//var_dump($tweet);
				if($tweet != FALSE){
					echo '<p class="alert alert-success">Tweet Submitted successfully.</p>';
					echo '<p class="alert alert-success"><a href="https://twitter.com/'.$_POST["screen_name"].'/status/'.$tweet->id_str.'" title="view on Twitter" target="_black">View on twitter</a></p>';	
					die;
				} else {
					echo '<p class="alert alert-danger">Tweet Could not send.</p>';	
					die;					
				}


			}
		}


		//operations

		public function update_account(){
			if(!$_POST || empty($_POST['id'])){
				return FALSE;
			}
			$this->load->model('twitteroauth_model');
			return $this->twitteroauth_model->update_account($_POST['id']);
		}

		public function delete_account(){
			if(!$_POST || empty($_POST['id'])){
				echo FALSE;
			}

			$id = $_POST['id'];
			$this->db->where('id', $id);
			$this->db->delete('accounts');			
			if($this->db->affected_rows() > 0){
				echo TRUE;
			} else {
				echo FALSE;
			}
			die;
		}
		
	}//End class

 ?>