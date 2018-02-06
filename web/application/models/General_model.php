<?php

	class General_model extends CI_Model {

		private $dir_uploads = 'content/uploads';
	   
	   public function __construct(){
			parent::__construct();
			//$this->load->database();
		}

		public function title(){
			$title = $this->controller != '' ? $this->controller.' | ' : '';
			return $title.$this->config->item('platform');
		}

		public function active_in_menu($string){
			if(strpos($this->controller, $string) !== FALSE){
				echo 'active';
			} else {
				return;
			}
			return;
		}
		
		public function site_url($url = ''){
			return $this->config->item('base_url').$url;
		}


		public function template_url($url = ''){
			$template = $this->site_url();
			return $template.'application/views/'.$url;
		}
		
		public function js($script = '', $echo = FALSE){
		   $src = $this->template_url('js/'.$script);
		   if($echo){
		      echo '<script type="text/javascript" src="'.$src.'">'.PHP_EOL;
		      echo '</script>'.PHP_EOL;
		      return;
		   } else{
		      return $src;
		   }
		}
		
		public function css($style = '', $echo = FALSE){
		   $href = $this->template_url('css/'.$style);
		   if($echo){
		      echo '<link rel="stylesheet" type="text/css" href="'.$href.'">'.PHP_EOL;
		      return;
		   } else{
		      return $href;
		   }
		}

		public function get_header(){
			return $this->load->view('_includes/header');
		}

		public function get_footer(){
			return $this->load->view('_includes/footer');
		}

		public function template($view, $data = '', $header = TRUE, $footer = TRUE){
			if($header === TRUE){
				$this->get_header();
			}

			$this->load->view('sections/'.$view, $data);

			if($footer === TRUE){
				$this->get_footer();
			}
		}

		public function timezones(){

			//code provide by XeonCross in GitHub
			//visit https://gist.github.com/Xeoncross/1204255
			//
			$regions = array(
			    'Africa' => DateTimeZone::AFRICA,
			    'America' => DateTimeZone::AMERICA,
			    'Antarctica' => DateTimeZone::ANTARCTICA,
			    'Aisa' => DateTimeZone::ASIA,
			    'Atlantic' => DateTimeZone::ATLANTIC,
			    'Europe' => DateTimeZone::EUROPE,
			    'Indian' => DateTimeZone::INDIAN,
			    'Pacific' => DateTimeZone::PACIFIC
			);

			$timezones = array();
			foreach ($regions as $name => $mask)
			{
			    $zones = DateTimeZone::listIdentifiers($mask);
			    foreach($zones as $timezone)
			    {
					// Lets sample the time there right now
					$time = new DateTime(NULL, new DateTimeZone($timezone));

					// Us dumb Americans can't handle millitary time
					$ampm = $time->format('H') > 12 ? ' ('. $time->format('g:i a'). ')' : '';

					// Remove region name and add a sample time
					$timezones[$name][$timezone] = substr($timezone, strlen($name) + 1) . ' - ' . $time->format('H:i') . $ampm;
				}
			}		
			
			return $timezones;	
		}

		public function sanitize_post($post){
			foreach ($post as $key => $value) {
				if(empty($value)){
					echo '<p class="alert alert-success">Field "' . ucfirst(str_replace('_', ' ', $key)) . '" can not be empty.</p>'; 
					die();
				}
				if($key == 'email_admin' || $key == 'userOrEmail'){
					$this->load->helper('email');
					if(!valid_email($value)){
					echo '<p class="alert alert-danger">Please enter a valid email.</p>'; 
					die();
					}
				}


			}

			if(array_key_exists('old_password', $post)){
				if($post['old_password'] !== $this->get_password()){
					echo '<p class="alert alert-danger">Wrong password.</p>'; 
					die();					
				}
				if($post['new_password'] !== $post['retype_password']){
					echo '<p class="alert alert-danger">The passwords does not match .</p>'; 
					die();
				}
			}
			return $this;
		}
		
		public function count_accounts($echo = false){
		   $count = $this->db->count_all('accounts');
		   if($echo){
		      echo $count;
		      return;
		   } 
		   return $count;
		}
		
		public function count_campaigns($echo = false){
		   $count = $this->db->count_all('campaigns');
		   if($echo){
		      echo $count;
		      return;
		   } 
		   return $count;
		}
		
		public function count_tweets($echo = false){
		   $count = $this->db->count_all('tweets');
		   if($echo){
		      echo $count;
		      return;
		   } 
		   return $count;
		}
		
		public function e_count($table){
			$method = 'count_'.$table;
			return $this->$method(TRUE);
		}
		
	public function get_data_by_field($table, $field, $data, $limit = 0, $return = 'array'){
	   if(empty($table) || empty($field) || empty($data)){return;}
	
	$query = "SELECT * FROM ".$table." WHERE ".$field."='".$data."'";
	
	if($limit > 0 ){
	   $query .= " LIMIT ".$limit;
	}
	
	$data = $this->db->query($query);
	return $return == 'array' ? $data->result_array() : $data;
	   }
	   
	   public function get_data_by_id($table, $id, $return = 'array'){
	      if(empty($table) || empty($id)){return;}
	      $this->db->where('id', $id);
	      $data = $this->db->get($table);
	      return $return == 'array' ? $data->result_array() : $data;
	      
	   }
	   
	   public function get_all($table){
	   	if(!empty($table)){
	   		$method = 'count_'.$table;
	   		if($count = $this->$method() == 0) {return $count;}
	   		$data = $this->db->get($table);
	   		return $data->result_array();
	   	} 
	   	return false;
	   }

	   private function get_password(){
	   	$pass = $this->get_settings();
	    $password = $pass[0]['password'];

	    return $password != 'admin' ? base64_decode($password) : $password;
	   }

	   public function get_settings(){
	   	  $data = $this->db->get('settings');
	   	   return $data->result_array();
	   }

	   public function get_allowed_errors(){
	   	$data = $this->get_settings();
	   	return $data[0]['allowed_errors'];
	   }

	   public function update_errors_account($id_campaign){
	   	$this->db->query("UPDATE campaigns SET num_errors= num_errors + 1 WHERE id=".$id_campaign);
	   	return;
	   }

	   public function delete_tweet($id){
	   	$this->db->where('id', $id);
	   	$this->db->delete('tweets');
	   	return;
	   }

	   

		public function get_data_for_pagination($table, $start, $limit){
			$data = $this->db->get($table, $limit, $start);
			return $data->result_array();
		}


		public function update_settings($post){
			if(!is_array($post)){ return FALSE;}

			$this->db->where('id', 1);
			$this->db->update('settings', $post);
	
			return TRUE;
		}

		public function change_password($post){
			if(!is_array($post) || count($post) < 3){ return FALSE;}

				unset($post['old_password']);
				unset($post['retype_password']);
				
				$password['password'] = base64_encode($post['new_password']);
				return $this->update_settings($password);

		}

		public function check_login(){
		  if(!$this->session->userdata('logged_in') || $this->session->userdata('logged_in') == null) {
			  $this->load->helper('url');
			   $this->session->set_userdata('url_redirect',current_url());
				$this->redirect($this->site_url('index.php/login', 1000));
				die();
   		  }
		}

		public function redirect($url_redirect = '', $time = 1000){
			if($url_redirect == ''){
				$url_redirect = $this->site_url('index.php');
			}
			echo '<script type="text/javascript">';
			echo    'function Redirecting(){
                       window.location="'.$url_redirect.'";
                     } 
                      setTimeout ("Redirecting()", '.$time.');';
            echo '</script>';
		}
	   
	}//end class general_model