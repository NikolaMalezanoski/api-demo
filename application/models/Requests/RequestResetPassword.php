<?php

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     required={"email"}
 * )
 */
class RequestResetPassword
{
	public function loadData($data){
		if (is_array($data) && array_key_exists("email", $data )){
			$this->email = $data['email'];
		}
	}
	/**
	 * @OA\Property(type="string", example="test@majstorce.mk" )
	 * @var string
	 */
	public $email;

	public function getDataArray(){
		return [
			"email" => $this->email,
		];
	}

	public function getEmail(){
		return $this->email;
	}

}
