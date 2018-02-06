<?php 
	
	class Callback extends CI_Controller {
		public $controller = 'Callback';

		public function __construct(){
			parent::__construct();
		}

		public function index(){
			$request_token                       = [];
			$request_token['oauth_token']        = $this->session->userdata('oauth_token');
			$request_token['oauth_token_secret'] = $this->session->userdata('oauth_token_secret');

			if (isset($_REQUEST['oauth_token']) && $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
    			die("Abort! Data invalid");
			}

			$this->load->library('Twitteroauth', array('consumer_key' => $this->config->item('consumer_key'), 'consumer_key_secret' => $this->config->item('consumer_key_secret'), 'oauth_token' => $request_token['oauth_token'], 'oauth_token_secret' => $request_token['oauth_token_secret']));

			$access_token = $this->twitteroauth->oauth("oauth/access_token", array('oauth_verifier' => $_REQUEST['oauth_verifier']));

			$this->session->set_userdata('access_token', $access_token);
			$this->session->unset_userdata('oauth_token');
			$this->session->unset_userdata('oauth_token_secret');

			header('location: '.$this->general_model->site_url().'index.php/callback/profile');
			die();


		}

		public function profile(){
			$access_token = $this->session->userdata('access_token');
				$this->load->library('Twitteroauth', array('consumer_key' => $this->config->item('consumer_key'), 'consumer_key_secret' => $this->config->item('consumer_key_secret'), 'oauth_token' => $access_token['oauth_token'], 'oauth_token_secret' => $access_token['oauth_token_secret']));
				$this->session->unset_userdata('access_token');
			$user = $this->twitteroauth->get("account/verify_credentials", array('include_email' => TRUE));

			$id_twitter         = $user->id_str;
			$screen_name        = $user->screen_name;
			$oauth_token        = $access_token['oauth_token'];
			$oauth_token_secret = $access_token['oauth_token_secret'];
			$statuses_count     = $user->statuses_count;
			$followers_count    = $user->followers_count;
			$favourites_count   = $user->favourites_count;
			$friends_count      = $user->friends_count;
			$profile_image_url  = $user->profile_image_url;

			$data = array('id_twitter'         => $id_twitter,
						  'screen_name'        => $screen_name,
						  'oauth_token'        => $oauth_token,
						  'oauth_token_secret' => $oauth_token_secret,
						  'statuses_count'     => $statuses_count,
						  'followers_count'    => $followers_count,
						  'favourites_count'   => $favourites_count,
						  'friends_count'      => $friends_count,
						  'profile_image_url'  => $profile_image_url
						);
			$account = $this->general_model->get_data_by_field('accounts', 'id_twitter', $id_twitter, 1, FALSE);
			if($account->num_rows() > 0){
				$this->db->where('id_twitter', $data['id_twitter']);
				$this->db->update('accounts', $data);
			  header('location: '.$this->general_model->site_url('index.php/accounts#'.$screen_name));
				die;
			}
			$this->load->model('accounts_model');
			if($this->accounts_model->insert($data)){
			  header('location: '.$this->general_model->site_url('index.php/accounts#'.$screen_name));
				die;
			}


		}

	}// end class

 ?>