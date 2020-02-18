<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SendEmailResetPassword extends CI_Model
{

	public function sendResetPasswordEmail(ClientModel $clientModel){

		$this->load->library('email');
		$this->email->from(EMAIL_FROM_NO_REPLAY_EMAIL, EMAIL_FROM_NO_REPLAY_NAME);

		$this->email->subject('Majstorce - Reset Password');
		$this->email->to($clientModel->getEmail());

		$data =[
			'tokenForResetPassword' => $clientModel->getTokenForResetPassword()
		];
		$body = $this->load->view('emails/reset_password', $data, true);
		$this->email->message($body);

		return $this->email->send();

	}

}
