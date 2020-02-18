<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form_validation_refresh_token
{
	public $status = false;
	public $error = [];
	public $message = '';

	public function __construct()
	{
		$this->CI = & get_instance();
	}

	public function validation(RequestRefreshTokenExchange $RequestRefreshTokenExchange){
		// populate Form with data
		$this->CI->form_validation->set_data($RequestRefreshTokenExchange->getDataArray());

		//setup Form validation
		$this->CI->form_validation->set_rules('refreshToken', 'RefreshToken', 'required|trim|max_length[100]');

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
}
