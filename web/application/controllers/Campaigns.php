<?php 

	class Campaigns extends CI_Controller {
		public $controller = 'Campaigns';

		public function __construct(){
			parent::__construct();
		}

		public function index($page = 1){
			
			$page_size                = 5;
			$max_pages                = 10;
			$start                    = ($page-1) * $page_size;
			$number_campaigns         = $this->general_model->count_campaigns();
			$total_pages              = ceil($number_campaigns / $page_size);
			$data['page']             = $page;
			$data['campaigns']        = $this->general_model->get_data_for_pagination('campaigns',$start,$page_size);
			$data['page_size']        = $page_size;
			$data['max_pages']        = $max_pages;
			$data['start']            = $start;
			$data['number_campaigns'] = $number_campaigns;
			$data['total_pages']      = $total_pages;

			$this->general_model->template('campaigns/campaigns', $data);
		}

		public function update_campaign($id = NULL){
			$this->controller = 'Update Campaign';
			$this->load->model('accounts_model');
			$data['campaign'] = $this->general_model->get_data_by_id('campaigns',$id);
			$this->general_model->template('campaigns/update-campaign', $data);
		}

		public function form_update_campaign(){
			if(!$_POST) die();

			$this->general_model->sanitize_post($_POST);
			$this->load->model('campaigns_model');
			$this->campaigns_model->update_campaign($_POST);
		}

		public function add_campaign($id_account = NULL){
			$this->controller = 'Add Campaingn';
			$this->load->model('accounts_model');
			$data = [];
			$data['id_account'] = $id_account;

			$this->general_model->template('campaigns/add-campaign', $data);
		}

		public function delete_campaign(){
			if(!$_POST || empty($_POST['id'])){
				echo FALSE;
			}

			$id = $_POST['id'];
			$this->db->where('id', $id);
			$delete = $this->db->delete('campaigns');
			//$delete->free_result();
			$this->db->where('id_campaign', $id);
			$this->db->delete('tweets');
			if($this->db->affected_rows() > 0){
				echo TRUE;
			} else {
				echo FALSE;
			}
			die;
		}

		public function update_account(){

		}

		//Adds Campaigns
		
		public function form_add_campaign(){
			if(!$_POST) {die;}
			$this->general_model->sanitize_post($_POST);
			$this->load->model('campaigns_model');
			return $this->campaigns_model->add_only_text($_POST);
		}

		

		
	}//End class

 ?>