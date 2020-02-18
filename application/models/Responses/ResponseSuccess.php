<?php

use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
class ResponseSuccess
{
	/**
	 * @OA\Property(type="string", example="success" )
	 * @var string
	 */
	public $status = 'success';


	public function getDataArray(){
		return [
			"status" => $this->status,
		];
	}
}
