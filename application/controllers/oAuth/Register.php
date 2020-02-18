<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use OpenApi\Annotations as OA;

class Register extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @OA\Post(
	 *     path="/oauth/register",
	 *     description="Cliant Registraion",
	 *     tags={"Authentication"},
	 *     @OA\RequestBody(
	 *     		@OA\JsonContent(ref="#components/schemas/RequestClientRegister")
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
	public function register_post()
	{
		// Load Client Model
		$this->load->model('Requests/RequestClientRegister');
		$this->load->model('Responses/ResponseAuthorizationTokens');
		$this->load->model('Responses/ResponseFail');
		$this->load->model('ClientModel');
		$this->load->model('OAuthClientTokensModel');

		$this->load->library('Form_validation_client_register');

		$this->RequestClientRegister->loadData($this->request->body);
		$this->form_validation_client_register->registerClientValidation($this->RequestClientRegister);

		if ($this->form_validation_client_register->getStatus() == false) {
			$this->ResponseFail->status = 'fail';
			$this->ResponseFail->errors = $this->form_validation_client_register->getErrors();
			$this->response($this->ResponseFail->getDataArray(), $this::HTTP_PRECONDITION_FAILED, true);
		}

		// set
		$this->ClientModel->setEmail($this->RequestClientRegister->email);
		$this->ClientModel->setFirstName($this->RequestClientRegister->firstName);
		$this->ClientModel->setPassword(password_hash($this->RequestClientRegister->password, PASSWORD_DEFAULT));
		$clientID = $this->ClientModel->insertClient();

		//Load CLient Data into a class
		$this->ClientModel->loadClientByID($clientID);

		// generate refresh token and access token and store into database
		$this->OAuthClientTokensModel->generateRefreshAndAccessTokens($this->ClientModel);

		// return response
		$this->response(
			$this->ResponseAuthorizationTokens->returnTokens($this->OAuthClientTokensModel)
			, $this::HTTP_CREATED,
			true
		);

	}
}
