<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form_validation_category
{
	public $status = false;
	public $error = [];
	public $message = '';

	public function __construct()
	{
		$this->CI = & get_instance();
	}

	public function registerCategoryValidation(RequestCategory $RequestCategory){
		// populate Form with data
		$this->CI->form_validation->set_data($RequestCategory->getDataArray());

		//setup Form validation
		$this->CI->form_validation->set_rules('parent', 'Parent', 'numeric');
		$this->CI->form_validation->set_rules('name', 'Name', 'required|trim|max_length[100]|is_unique[category_cat.cat_name]');
		$this->CI->form_validation->set_rules('slug', 'Slug', 'trim|max_length[255]');
		$this->CI->form_validation->set_rules('tags','Tags','trim');

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
