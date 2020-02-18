<?php

use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
class ResponseFail
{
	/**
	 * @OA\Property(type="string", example="fail" )
	 * @var string
	 */
	public $status = 'fail';

	/**
	 * @OA\Property(type="object", example="{email: This Email already exists please enter another email address}")
	 * @var array
	 */
	public $errors;

	public function getDataArray(){
		return [
			"status" => $this->status,
			"errors" => $this->errors
		];
	}
}
