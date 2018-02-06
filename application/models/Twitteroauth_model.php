<?php 

	class Twitteroauth_model extends CI_Model {

		private $twitter;
		private $limit_characters = 140;
		private $media_uploaded  = 0;
		private $ids_media_uploaded = array();
		public  $response;

		public function __construct(){
			parent::__construct();
		}

		private function set_conection_app(){
			$consumerKey       = $this->config->item('consumer_key');
			$consumerKeySecret = $this->config->item('consumer_key_secret');
			$params = array('consumer_key' => $consumerKey, 'consumer_key_secret' => $consumerKeySecret);
			$this->load->library('Twitteroauth', $params);
			$this->set();
		}

		private function set_connection_account($id){
				$account = $this->general_model->get_data_by_id('accounts',$id, 'data');
				 if($account->num_rows() > 0){
				 	$ac = $account->result_array();
				 	 $this->load->library('Twitteroauth', array('consumer_key' => $this->config->item('consumer_key'), 'consumer_key_secret' => $this->config->item('consumer_key_secret'), 'oauth_token' => $ac[0]['oauth_token'], 'oauth_token_secret' => $ac[0]['oauth_token_secret']));
				 	 $this->set();
				 	 		return TRUE;
				 } else { 
				 	return FALSE;
				 }
		}

		private function get_url_authorization(){
			$this->set_conection_app();
			$request_token = $this->twitteroauth->oauth('oauth/request_token', array('oauth_callback' => $this->config->item('oauth_callback')));
			$this->session->set_userdata('oauth_token', $request_token['oauth_token']);
			$this->session->set_userdata('oauth_token_secret', $request_token['oauth_token_secret']);
			return $this->twitteroauth->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
		}

		public function url_authorization(){
			echo $this->get_url_authorization();	
		}

		private function set(){
			$this->twitteroauth->setTimeouts(10, 10);
			$this->twitteroauth->setRetries(3, 5);
			$this->twitteroauth->setUserAgent($this->config->item('platform').' '.$this->config->item('platform_version'). ' ( +'.str_replace('index.php', '',$this->config->item('base_url')).')');
		}

		private function httpCode(){
			return $this->twitteroauth->getLastHttpCode() === 200 ? TRUE : FALSE;
		}

		public function send_simple_tweet($account_id, $text){
		       $this->set_connection_account($account_id);
			  if(is_string($text) && strlen($text) < $this->limit_characters){
			  	$tweet = $this->twitteroauth->post('statuses/update', array('status' => $text));
			  	
			  		return $this->httpCode() ? $tweet : $this->httpCode(); 
			  } else {
			  	return FALSE;
			  }
		}

		private function determine_extension($filename){
			$ext = end(explode('.', $filename));
			return $ext;
		}

		public function upload_media($file, $account_id){
			if(file_exists($file)){
			  $this->set_connection_account($account_id);
			  $media = $this->twitteroauth->upload('media/upload', array('media' => $file));
			   if($this->httpCode()){
				$this->media_uploaded++;
				array_push($this->ids_media_uploaded, $media->media_id_string);
				return TRUE;
		    }
			return FALSE;
		}
	}

		public function send_tweet_whit_media($account_id, $text){
			if($this->media_uploaded > 0 && count($this->ids_media_uploaded) > 0){
				$params = array('status'    => $text,
								'media_ids' => implode(',', $this->ids_media_uploaded));
				$this->set_connection_account($account_id);
				$tweet = $this->twitteroauth->post('statuses/update', $params);
				return $this->httpCode() ? $tweet : $this->httpCode(); 
			} else {
				$tweet = $this->send_simple_tweet($account_id, $text);
				return $tweet;
			}
			return FALSE;
		}

		public function update_account($id){
			$this->set_connection_account($id);
			$user = $this->twitteroauth->get("account/verify_credentials", array('include_email' => TRUE, 'skip_status' => TRUE));

			$id_twitter         = $user->id_str;
			$screen_name        = $user->screen_name;
			$statuses_count     = $user->statuses_count;
			$followers_count    = $user->followers_count;
			$favourites_count   = $user->favourites_count;
			$friends_count      = $user->friends_count;
			$profile_image_url  = $user->profile_image_url;

			$data = array('id_twitter'         => $id_twitter,
						  'screen_name'        => $screen_name,
						  'statuses_count'     => $statuses_count,
						  'followers_count'    => $followers_count,
						  'favourites_count'   => $favourites_count,
						  'friends_count'      => $friends_count,
						  'profile_image_url'  => $profile_image_url
						);

			if($this->httpCode()){

				$this->db->where('id_twitter', $id_twitter);
				$this->db->update('accounts', $data);

				echo true;
				return;
			} else {
				echo false;
				return;
			}
		}


	}//end class

 ?>