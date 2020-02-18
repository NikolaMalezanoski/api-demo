<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use OpenApi\Annotations as OA;

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->model('ClientModel' );
		$this->ClientModel->loadClientByID(6);
		$this->load->view('welcome_message');
	}

	public function rewrite()
	{
		echo 'Rewrite rules works';
	}
}
