<?php

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     required={"refresh-token"}
 * )
 */
class RequestRefreshTokenExchange
{
	public function loadData($data){
		if (is_array($data) && array_key_exists("refreshToken", $data )){
			$this->refreshToken = $data['refreshToken'];
		}
	}
	/**
	 * @OA\Property(type="string", example="XXXYYYZZZaa1122" )
	 * @var string
	 */
	public $refreshToken;

	public function getDataArray(){
		return [
			"refreshToken" => $this->refreshToken,
		];
	}

	public function getRefreshToken(){
		return $this->refreshToken;
	}

}
