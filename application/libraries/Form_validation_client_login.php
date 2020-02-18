<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form_validation_client_login
{
	public $status = false;
	public $error = [];
	public $message = '';

	public function __construct()
	{
		$this->CI = & get_instance();
	}

	public function registerClientValidation(RequestClientLogin $RequestClientLogin){
		// populate Form with data
		$this->CI->form_validation->set_data($RequestClientLogin->getDataArray());

		//setup Form validation
		$this->CI->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|max_length[100]');
		$this->CI->form_validation->set_rules('password', 'Password', 'required|trim|max_length[100]');

		// Form validation
		if ($this->CI->form_validation->run() == FALSE) {
			// Form Validation Errors
			$this->status = false;
			$this->error = $this->CI->form_validation->error_array();
			$this->message = validation_errors();
		} else {
			$this->status = true;
		}
		return ;
	}

	public function getStatus(){
		return $this->status;
	}

	public function getErrors(){
		return $this->error;
	}

	public function getMessage(){
		return $this->message;
	}

	public function isPasswordEqual($clientPasswordFromRequest, $clientPasswordFromDB ){
		return password_verify($clientPasswordFromRequest, $clientPasswordFromDB );
	}
}
