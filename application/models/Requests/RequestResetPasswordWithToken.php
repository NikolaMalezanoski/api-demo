<?php

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     required={"email"}
 * )
 */
class RequestResetPasswordWithToken
{
	public function loadData($data){
		if (is_array($data) && array_key_exists("token", $data )){
			$this->token = $data['token'];
		}
		if (is_array($data) && array_key_exists("password", $data )){
			$this->password = $data['password'];
		}
		if (is_array($data) && array_key_exists("confirmPassword", $data )){
			$this->confirmPassword = $data['confirmPassword'];
		}
	}
	/**
	 * @OA\Property(type="string", example="XXYYZZZ" )
	 * @var string
	 */
	public $token;

	/**
	 * @OA\Property(type="string", example="Password1")
	 * @var string
	 */
	public $password;

	/**
	 * @OA\Property(type="string", example="Password1")
	 * @var string
	 */
	public $confirmPassword;


	public function getDataArray(){
		return [
			"token" => $this->token,
			"password" => $this->password,
			"confirmPassword" => $this->confirmPassword,
		];
	}

	public function getToken(){
		return $this->token;
	}

	public function getPassword(){
		return $this->password;
	}

	public function getConfirmPassword(){
		return $this->confirmPassword;
	}

}
