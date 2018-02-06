<?php

	class Accounts_model extends CI_Model {
	   
	   public function __construct(){
			parent::__construct();
			//$this->load->database();
		}



		public function insert($data){
			if(is_array($data)){
				$this->db->insert('accounts', $data);
				return $this->db->insert_id() > 0 ? true : false;
			} 

			return false;
		}

		public function edit(){

		}

	    public function delete($id){
	    	
	    }

	    public function select_accounts($id = null){
	    	$accounts = $this->general_model->get_all('accounts');
	    	if($accounts === 0){
	    		echo 'not accounts';
	    		return;
	    	}

	    	echo '<select class="form-control" name="account_id">';
	    		foreach ($accounts as $account) {
	    			$option = '<option value="'.$account['id'].'"';
	    			if($id !== null){
	    				if($id === $account['id']){
	    					$option .= 'selected';
	    				}
	    			}
	    			$option .= '>'.$account['screen_name'].'</option>';

	    			echo $option;
	    		}
	    	echo '</select>';

	    	return;
	    }
	} //End class