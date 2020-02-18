<?php
use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */

class JWTAccessToken
{
	/**
	 * @OA\Property(type="integer", example="1" )
	 * @var int
	 */
	public $id;

	/**
	 * @OA\Property(type="string", example="test@majstorce.m" )
	 * @var string
	 */
	public $email;

	/**
	 * @OA\Property(type="string", example="MajstorMarko" )
	 * @var string
	 */
	public $firstName;

	/**
	 * @OA\Property(type="integer", example=1577463224 )
	 * @var int
	 */
	public $time;

	/**
	 * @OA\Property(type="integer", example=1577463224 )
	 * @var int
	 */
	public $exp;

	/**
	 * @OA\Property(type="object" )
	 * @var string
	 */
	public $scope;


	public function setID($var){
		$this->id = $var;
	}
	public function getID(){
		return $this->id;
	}

	public function setEmail($var){
		$this->email = $var;
	}
	public function getEmail(){
		return $this->email;
	}

	public function setFirstName($var){
		$this->firstName = $var;
	}
	public function getFirstName(){
		return $this->firstName;
	}

	public function setTime($var){
		$this->time = $var;
	}
	public function getTime(){
		return $this->exp;
	}

	public function setExp($var){
		$this->exp = $var;
	}
	public function getExp(){
		return $this->exp;
	}

	public function setScope($var){
		$this->scope = $var;
	}
	public function getScope(){
		return $this->scope;
	}

	public function setData($JWTAccessToken){
		$this->setID($JWTAccessToken->id);
		$this->setEmail($JWTAccessToken->email);
		$this->setFirstName($JWTAccessToken->firstName);
		$this->setTime($JWTAccessToken->time);
		$this->setExp($JWTAccessToken->exp);
		$this->setScope($JWTAccessToken->scope);
	}

	public function getDataArray(){
		return [
			"id" => $this->id,
			"email" => $this->email,
			"firstName" => $this->firstName,
			"time" => $this->time,
			"exp" => $this->exp,
			"scope" => $this->scope,
		];
	}
}
