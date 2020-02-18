<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ClientModel extends ClientRecordSet
{

	public function createNewClient(RequestClientRegister $RequestClientRegister){
		$this->ClientModel->setEmail($this->RequestClientRegister->email);
		$this->ClientModel->setFirstName($this->RequestClientRegister->firstName);
		$this->ClientModel->setPassword(password_hash($this->RequestClientRegister->password, PASSWORD_DEFAULT));
	}

	public function generateResetPasswordToken(){
		$this->ClientModel->setTokenForResetPassword(generate_string(100));
		$this->ClientModel->updateClient();
	}



}


