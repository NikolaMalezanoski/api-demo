<?php

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     required={"email","password"}
 * )
 */
class RequestClientLogin
{
	public function loadData($data){
		if (is_array($data) && array_key_exists("email", $data )){
			$this->email = $data['email'];
		}
		if (is_array($data) && array_key_exists("password", $data )){
			$this->password = $data['password'];
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

	public function getDataArray(){
		return [
			"email" => $this->email,
			"password" => $this->password
		];
	}

	public function getEmail(){
		return $this->email;
	}

	public function getPassword(){
		return $this->password;
	}
}
