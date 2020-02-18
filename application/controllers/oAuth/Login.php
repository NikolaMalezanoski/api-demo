<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use OpenApi\Annotations as OA;

class Login extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

	/**
	 * @OA\Post(
	 *     path="/oauth/login",
	 *     description="Cliant Login",
	 *     tags={"Authentication"},
	 *     @OA\RequestBody(
	 *     		@OA\JsonContent(ref="#components/schemas/RequestClientLogin")
	 *	 	),
	 *     @OA\Response(
	 *			response="201",
	 *     		description="Registration was saccesfull",
	 * 			@OA\JsonContent(ref="#components/schemas/ResponseAuthorizationTokens")
	 * 		),
	 *      @OA\Response(
	 *			response="401",
	 *     		description="Invalid username or passsword",
	 *     		@OA\JsonContent(ref="#components/schemas/ResponseFail")
	 * 		),
	 * 		@OA\Response(
	 *			response="412",
	 *     		description="Precondition failed",
	 *     		@OA\JsonContent(ref="#components/schemas/ResponseFail")
	 * 		)
	 *)
	 */
    public function login_post()
    {
		// Load Client Model
		$this->load->model('Requests/RequestClientLogin');
		$this->load->model('Responses/ResponseAuthorizationTokens');
		$this->load->model('Responses/ResponseFail');
		$this->load->model('ClientModel');
		$this->load->model('OAuthClientTokensModel');

		$this->load->library('Form_validation_client_login');


		$this->RequestClientLogin->loadData($this->request->body);
		$this->form_validation_client_login->registerClientValidation($this->RequestClientLogin);

		if ($this->form_validation_client_login->getStatus() === false) {
			$this->ResponseFail->status = 'fail';
			$this->ResponseFail->errors = $this->form_validation_client_login->getErrors();
			$this->response($this->ResponseFail->getDataArray(), $this::HTTP_PRECONDITION_FAILED, true);
		}

		//Load Client Data into a class
		$this->ClientModel->loadClientByEmail($this->RequestClientLogin->getEmail());

		//check if we have client with that email
		if($this->ClientModel->getDataIsLoaded() === false){
			$this->ResponseFail->status = 'fail';
			$this->ResponseFail->errors = ['email' =>'Invalid Username or Password'];
			$this->response($this->ResponseFail->getDataArray(), $this::HTTP_UNAUTHORIZED, true);
		}

		//check if password is the same
		if ($this->form_validation_client_login->isPasswordEqual($this->RequestClientLogin->getPassword() , $this->ClientModel->getPassword()) == false) {
			$this->ResponseFail->status = 'fail';
			$this->ResponseFail->errors = ['email' =>'Invalid Username or Password'];
			$this->response($this->ResponseFail->getDataArray(), $this::HTTP_UNAUTHORIZED, true);
		}

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
