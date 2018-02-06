<?php 

	class Email_model extends CI_Model {

		public function __construct(){
			parent::__construct();
		}

		private function send_email($subject, $message){
			$admin = $this->general_model->get_settings()[0];
			$to = $admin['name_admin'].'<'.$admin['email_admin'].'>';
			$from = $this->config->item('platform') . '<noreply@'.$this->config->item('platform').'.bot>';
			$body = '<!DOCTYPE html>
					<html lang="en">
					<head>
					 <center>
					  <title>Message for admin | '.$this->config->item("platform").'</title>
					  <meta charset="utf-8">
					</head>
					<body>
						<h1>Hello, '.$admin["name_admin"].'</h1>

						<p>'
						    . $message .
						'<p>

						<footer>
							<p>
							   <small>
								 The content of this message is private, if you receive
								 this message in error please select it and notify to '.$admin['email_admin'].' Thanks 
								 for your help.
								</small>
							 </p>
						</footer>
				     </center>
				     </body>
					</html>';

			$headers = "From: ".$from . PHP_EOL;
			$headers .= "Reply-To: " . $from . PHP_EOL;
			$headers .= "MIME-Version: 1.0" . PHP_EOL;
			$headers .= "Content-type: text/html; charset=utf-8" . PHP_EOL;
			$headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;

			return @mail($to, $subject, $body, $headers);

		}

		public function no_tweets($name = ''){
			$subject = 'There are no more tweets';
			$message = 'This email is to inform you that the campaign with name '.$name.' no longer has tweets to be sent. This campaign has been inactivated and it is time to eliminate it. Thank you.';

			return $this->send_email($subject, $message);
		}

		public function errors_exceeded($name = ''){
			$subject = 'Campaign errors exceeded';
			$message = 'This email is to inform you that the campaign with name '.$name.' has reached the maximum number of errors allowed. This campaign has been disabled and you should review it. Thank you.';

			return $this->send_email($subject, $message);
		}

		public function recovery_password($message){
			$subject = "Password reset request";
			return $this->send_email($subject, $message);
		}

	}// end class Email_model