<?php 

	class Cron extends CI_Controller {
		public $controller = "Cron";
		private $campaigns = array();
		private $msg       = [];
		private $method;
		private $tweets    = [];


		public function __construct($method = "jobcron"){
			$this->method = $method;
			parent::__construct();
			$this->initialize();
		}

		public function index(){


		 ?>
			<!DOCTYPE html>
			<html>
			<head>
				<meta charset="utf-8">
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<title><?= $this->controller; ?></title>
			</head>
			<body>
				
			</body>
			</html>
		<?php } 

		private function initialize(){
			$this->controller = "Initializing Cron";
			$this->campaigns = [];
			$this->msg       = [];
			$this->prepare();

		}

		private function prepare(){
			$this->controller = "Prepare";
			$time = time();
			$this->db->select('*')->from('campaigns')->where(array('status' => 2, 'next_sent <=' => $time));
			$campaigns = $this->db->get()->result_array();
			array_push($this->campaigns, $campaigns);
		    count($this->campaigns[0]) == 0 ? $this->done() : $this->execute();
		}


		private function execute(){
			$this->controller = "Execute Cron";
			$this->campaigns = $this->campaigns[0];
			foreach ($this->campaigns as $campaign) {
				if($campaign['num_errors'] <= $this->general_model->get_allowed_errors()){
				//1 normal, 2 random;
				$query = "SELECT * FROM tweets WHERE id_campaign=".$campaign['id'];
				$query .= $campaign['shipping_mode'] == 2 ? " ORDER BY RAND() LIMIT 1 " : " LIMIT 1";
				$tweet = $this->db->query($query);
					if($tweet->num_rows() == 0){
						$data = array('status' => 1 );
						$this->db->where('id', $campaign['id']);
						$this->db->update('campaigns', $data);	
						$this->load->model('email_model');
						$this->email_model->no_tweets($campaign['name']);
					} else {
						$tweet = $tweet->result_array()[0];
						$tweet['account_id'] = $campaign['account_id'];
						$tweet['time_to_execute']  = $campaign['time_to_execute'];
						array_push($this->tweets, $tweet);
			          }
			   } else {
			   	//poner la campaña inactiva y avisar
			   			$data = array('status' => 1 );
						$this->db->where('id', $campaign['id']);
						$this->db->update('campaigns', $data);
				    	$this->load->model('email_model');
					    $this->email_model->errors_exceeded($campaign['name']);
			   }
			}
			count($this->tweets) == 0 ? $this->done() : $this->finalize();
       	}

		private function finalize(){
			$this->controller = "Finalize Cron";
			$this->load->model('twitteroauth_model');
			foreach ($this->tweets as $tweet) {
			  $send = $this->twitteroauth_model->send_simple_tweet($tweet['account_id'], $tweet['text']);
			   if(!$send){
			   		$this->general_model->update_errors_account($tweet['id_campaign']);
			   } else {
			   	$this->general_model->delete_tweet($tweet['id']);
			   	$this->db->where('id', $tweet['id_campaign']);
			   	$data = array('last_sent' => time(), 'next_sent' => time() + $tweet['time_to_execute']  );
			   	$this->db->update('campaigns', $data);
			   }
			}

			$this->done();
		}

		private function done(){
			$this->controller = "Cron Done";
		    $this->campaigns = array();
		    $this->msg       = [];
		    $this->method;
		    $this->tweets    = [];
		    if($this->method != "jobcron"){
		    	echo "Cron executed successfully";
		    }
		}
	}

?>

