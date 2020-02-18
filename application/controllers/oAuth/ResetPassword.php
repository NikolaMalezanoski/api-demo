<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use OpenApi\Annotations as OA;

class ResetPassword extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @OA\Post(
	 *     path="/oauth/reset-password/request",
	 *     description="Reset Password",
	 *     tags={"Authentication"},
	 *     @OA\RequestBody(
	 *     		@OA\JsonContent(ref="#components/schemas/RequestResetPassword")
	 *	 	),
	 *     @OA\Response(
	 *			response="200",
	 *     		description="Email for reset password is sent",
	 * 			@OA\JsonContent(ref="#components/schemas/ResponseSuccess")
	 * 		),
	 * 		@OA\Response(
	 *			response="412",
	 *     		description="Precondition failed",
	 *     		@OA\JsonContent(ref="#components/schemas/ResponseFail")
	 * 		)
	 *)
	 */
	public function request_post()
	{
		// Load Client Model
		$this->load->model('Requests/RequestResetPassword');
		$this->load->model('Responses/ResponseSuccess');
		$this->load->model('Responses/ResponseFail');
		$this->load->model('ClientModel');
		$this->load->model('SendEmailResetPassword');

		$this->load->library('Form_validation_reset_password');
		$this->RequestResetPassword->loadData($this->request->body);
		$this->form_validation_reset_password->validation($this->RequestResetPassword);

		if ($this->form_validation_reset_password->getStatus() == false) {
			$this->ResponseFail->status = 'fail';
			$this->ResponseFail->errors = $this->form_validation_reset_password->getErrors();
			$this->response($this->ResponseFail->getDataArray(), $this::HTTP_PRECONDITION_FAILED, true);
		}

		//Load Client Data into a class
		$this->ClientModel->loadClientByEmail($this->RequestResetPassword->getEmail());

		// if we dont find client
		if (!$this->ClientModel->getDataIsLoaded()){
			$this->ResponseFail->status = 'fail';
			$this->ResponseFail->errors = ['email'=>'invalid email'];
			$this->response($this->ResponseFail->getDataArray(), $this::HTTP_PRECONDITION_FAILED, true);
		}

		$this->ClientModel->generateResetPasswordToken();
		$this->SendEmailResetPassword->sendResetPasswordEmail($this->ClientModel);


		// return response
		$this->response(
			$this->ResponseSuccess->getDataArray()
			,$this::HTTP_OK
			,true
		);

	}

	/**
	 * @OA\Post(
	 *     path="/oauth/reset-password/new-rassword",
	 *     description="Reset Password With Token",
	 *     tags={"Authentication"},
	 *     @OA\RequestBody(
	 *     		@OA\JsonContent(ref="#components/schemas/RequestResetPasswordWithToken")
	 *	 	),
	 *     @OA\Response(
	 *			response="200",
	 *     		description="Sucessfully update password",
	 * 			@OA\JsonContent(ref="#components/schemas/ResponseSuccess")
	 * 		),
	 * 		@OA\Response(
	 *			response="412",
	 *     		description="Precondition failed",
	 *     		@OA\JsonContent(ref="#components/schemas/ResponseFail")
	 * 		)
	 *)
	 */
	public function newPasswordWithToken_post()
	{
		// Load Client Model
		$this->load->model('Requests/RequestResetPasswordWithToken');
		$this->load->model('Responses/ResponseSuccess');
		$this->load->model('Responses/ResponseFail');
		$this->load->model('ClientModel');


		$this->load->library('Form_validation_reset_password_with_token');
		$this->RequestResetPasswordWithToken->loadData($this->request->body);
		$this->form_validation_reset_password_with_token->validation($this->RequestResetPasswordWithToken);

		if ($this->form_validation_reset_password_with_token->getStatus() == false) {
			$this->ResponseFail->status = 'fail';
			$this->ResponseFail->errors = $this->form_validation_reset_password_with_token->getErrors();
			$this->response($this->ResponseFail->getDataArray(), $this::HTTP_PRECONDITION_FAILED, true);
		}

		//Load Client Data into a class
		$this->ClientModel->loadClientByResetPasswordToken($this->RequestResetPasswordWithToken->getToken());

		// if we dont find client
		if (!$this->ClientModel->getDataIsLoaded()){
			$this->ResponseFail->status = 'fail';
			$this->ResponseFail->errors = ['toekn'=>'Invalid Token'];
			$this->response($this->ResponseFail->getDataArray(), $this::HTTP_PRECONDITION_FAILED, true);
		}

		$this->ClientModel->setPassword(password_hash($this->RequestResetPasswordWithToken->password, PASSWORD_DEFAULT));
		$this->ClientModel->setTokenForResetPassword(null);
		$this->ClientModel->updateClient();


		// return response
		$this->response(
			$this->ResponseSuccess->getDataArray()
			,$this::HTTP_OK
			,true
		);

	}


}
