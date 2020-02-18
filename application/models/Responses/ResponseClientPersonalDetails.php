<?php defined('BASEPATH') OR exit('No direct script access allowed');

use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
class ResponseClientPersonalDetails
{

	/**
	 * @OA\Property(type="string", example="success" )
	 * @var string
	 */
	public $status = 'success';

	/**
	 * @OA\Property(type="integer" )
	 * @var string
	 */
	public $id;

	/**
	 * @OA\Property(type="string" )
	 * @var string
	 */
	public $firstName;

	/**
	 * @OA\Property(type="string" )
	 * @var string
	 */
	public $email;

	/**
	 * @OA\Property(type="string" )
	 * @var string
	 */
	public $emailVerified;
	/**
	 * @OA\Property(type="string" )
	 * @var array
	 */

	public $scope;


	public function setData(ClientModel $ClientModel){


			$this->id =  $ClientModel->getId();
			$this->firstName =  $ClientModel->getFirstName();
			$this->email =  $ClientModel->getEmail();
			$this->emailVerified =  $ClientModel->getEmailVerified();
			$this->scope =  $ClientModel->getScope();

	}

	public function getData(){

		return [
			'id' =>  $this->id,
			'firstName' =>  $this->firstName,
			'email' =>  $this->email,
			'emailVerified' =>  $this->emailVerified,
			'scope' =>  $this->scope,
		];
	}
}
