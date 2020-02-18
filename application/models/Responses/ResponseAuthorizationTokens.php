<?php defined('BASEPATH') OR exit('No direct script access allowed');

use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
class ResponseAuthorizationTokens extends CI_Model
{

	/**
	 * @OA\Property(type="string", example="success" )
	 * @var string
	 */
	public $status = 'success';

	/**
	 * @OA\Property(type="string", example="xxx.yyy.zzz" )
	 * @var string
	 */
	public $accessToken = 'accessToken';

	/**
	 * @OA\Property(type="string", example="AYZAYZ123Ayz" )
	 * @var string
	 */
	public $refreshToken = 'refreshToken';

	public function returnTokens(OAuthClientTokensModel $OAuthClientTokensModel){

		return [
			'status' => $this->status,
			'accessToken' =>  $OAuthClientTokensModel->getAccessToken(),
			'refreshToken' =>  $OAuthClientTokensModel->getRefreshToken(),
		];
	}
}
