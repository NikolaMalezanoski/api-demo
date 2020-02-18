<?php

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     required={"email","password","confirmPassword","firstName"}
 * )
 */
class RequestClientRegister
{
	public function loadData($data){
		if (is_array($data) && array_key_exists("email", $data )){
			$this->email = $data['email'];
		}
		if (is_array($data) && array_key_exists("password", $data )){
			$this->password = $data['password'];
		}
		if (is_array($data) && array_key_exists("confirmPassword", $data )){
			$this->confirmPassword = $data['confirmPassword'];
		}
		if (is_array($data) && array_key_exists("firstName", $data )){
			$this->firstName = $data['firstName'];
		}

	}
	/**
	 * @OA\Property(type="string", example="test@majstorce.mk" )
	 * @var string
	 */
	public $email;

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

	/**
	 * @OA\Property(type="string", example="MajstorMarko")
	 * @var string
	 */
	public $firstName;

	public function getDataArray(){
		return [
			"email" => $this->email,
			"password" => $this->password,
			"confirmPassword" => $this->confirmPassword,
			"firstName" => $this->firstName
		];
	}
}
