<?php 

	class Campaigns_model extends CI_Model {

		private $limit_characters = 140;
		private $msg              = [];

		private function add_campaign($campaign){
			if(isset($campaign['tweets'])){unset($campaign['tweets']);}
			
			$seconds                     = $campaign['time_to_execute'] * 60;
			$campaign['time_to_execute'] = $seconds;
			$campaign['last_sent']       = 0;
			$campaign['next_sent']       = time() + $seconds;

			$select = $this->general_model->get_data_by_field('campaigns', 'name', $campaign['name'], 1, 'data');
			if($select->num_rows() > 0){
				echo '<p class="alert alert-warning">The campaign already exists, choose another name.</p>';
				die;
			}

			$this->db->insert('campaigns', $campaign);
			if($this->db->insert_id() > 0){
				return $this->db->insert_id();
			} else {
				return FALSE;
			}

		}

		private function add_tweets($tweets, $id_campaign){
    		$tweets = explode("\n", $tweets);
			$cont = 0;
			foreach ($tweets as $tweet) {
				if(strlen($tweet) <= $this->limit_characters){
					$this->db->insert('tweets', array('text' => $tweet, 'id_campaign' => $id_campaign));
					 if($this->db->insert_id() > 0){
					 	$cont++;
					 }
				}
			}

			return $cont;
		}

		private function get_msgs(){
			foreach ($this->msg as $key => $value) {
				echo $value;
			}
		}

		public function add_only_text($post){


			$id_campaign = $this->add_campaign($post);

			if($id_campaign !== FALSE){
				$this->msg[0] = '<p class="alert alert-success">The campaign '.$post['name'].' created successfully.</p>';
			} else {
				echo '<p class="alert alert-warning">There was a problem creating the campaign. Try again.</p>';
				die;
			}

			$count_tweets_added = $this->add_tweets($post['tweets'], $id_campaign);

			$class_msg = $count_tweets_added === 0 ? 'alert alert-warning' : 'alert alert-success';

			$this->msg[1] = '<p class="'.$class_msg.'">They have been inserted '.$count_tweets_added.' Tweets.</p>';

			$this->get_msgs(); 
			return;
		}

		public function update_campaign($post){

			$this->general_model->sanitize_post($post);

			$campaign = $this->general_model->get_data_by_id('campaigns', $post['id'], 'data');
			if($campaign->num_rows() < 1){
				echo '<p class="alert alert-warning">No data found... try again</p>'; 
				die;
			}

			$campaign = $campaign->result_array()[0];
			
			if($campaign['name'] != $post['name']){
				if($this->general_model->get_data_by_field('campaigns', 'name', $post['name'], $limit = 0, $return = 'data')->num_rows() > 0){
				echo '<p class="alert alert-warning">The campaign with this name '.$post['name'].' already exists. Choose another name</p>'; 
				die;					
				}
			} else{
				unset($post['name']);
			}

				$post['time_to_execute'] = $post['time_to_execute'] * 60;

				$this->db->where('id', $post['id']);
				unset($post['id']);
				$this->db->update('campaigns', $post);
				
				if($this->db->affected_rows() > 0){
					echo '<p class="alert alert-success">Campaign updated correctly.</p>';
					die;
				}

				echo '<p class="alert alert-info">No changes were made to the campaign..</p>';
				die;
		}

		
	} //End class

 ?>