<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use OpenApi\Annotations as OA;

class RefreshTokenExchange extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @OA\Post(
	 *     path="/oauth/refresh-token",
	 *     description="Exchange refresh token for a new access token",
	 *     tags={"Authentication"},
	 *     @OA\RequestBody(
	 *     		@OA\JsonContent(ref="#components/schemas/RequestRefreshTokenExchange")
	 *	 	),
	 *     @OA\Response(
	 *			response="201",
	 *     		description="Registration was saccesfull",
	 * 			@OA\JsonContent(ref="#components/schemas/ResponseAuthorizationTokens")
	 * 		),
	 * 		@OA\Response(
	 *			response="412",
	 *     		description="Precondition failed",
	 *     		@OA\JsonContent(ref="#components/schemas/ResponseFail")
	 * 		)
	 *)
	 */
	public function refreshTokenExchange_post()
	{
		// Load Client Model
		$this->load->model('Requests/RequestRefreshTokenExchange');
		$this->load->model('Responses/ResponseAuthorizationTokens');
		$this->load->model('Responses/ResponseFail');
		$this->load->model('ClientModel');
		$this->load->model('OAuthClientTokensModel');

		$this->load->library('Form_validation_refresh_token');
		$this->RequestRefreshTokenExchange->loadData($this->request->body);
		$this->form_validation_refresh_token->validation($this->RequestRefreshTokenExchange);

		if ($this->form_validation_refresh_token->getStatus() == false) {
			$this->ResponseFail->status = 'fail';
			$this->ResponseFail->errors = $this->form_validation_refresh_token->getErrors();
			$this->response($this->ResponseFail->getDataArray(), $this::HTTP_PRECONDITION_FAILED, true);
		}

		// generate refresh token and access token and store into database
		$this->OAuthClientTokensModel->loadOauthDataByRefreshToken($this->RequestRefreshTokenExchange->getRefreshToken());
		//check if we have client with that email
		if($this->OAuthClientTokensModel->getDataIsLoaded() === false){
			$this->ResponseFail->status = 'fail';
			$this->ResponseFail->errors = ['email' =>'Invalid refresh token'];
			$this->response($this->ResponseFail->getDataArray(), $this::HTTP_UNAUTHORIZED, true);
		}

		//Load Client Data into a class
		$this->ClientModel->loadClientByID($this->OAuthClientTokensModel->getClientId());

		// generate new refresh token and access token and store into database
		$this->OAuthClientTokensModel->generateNewAccessTokens($this->ClientModel);

		// return response
		$this->response(
			$this->ResponseAuthorizationTokens->returnTokens($this->OAuthClientTokensModel)
			,$this::HTTP_CREATED
			,true
		);

	}
}
