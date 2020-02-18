<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use OpenApi\Annotations as OA;

class PersonalDetails extends API_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->protectedByJWT();
	}

	/**
	 * @OA\Get(
	 *     path="/client/personal-details",
	 *     description="Cliant personal details",
	 *     tags={"Client"},
	 *     security={{"bearerAuth":{}}},
	 *     @OA\Response(
	 *			response="200",
	 *     		description="Registration was saccesfull",
	 * 			@OA\JsonContent(ref="#components/schemas/ResponseClientPersonalDetails")
	 * 		),
	 *      @OA\Response(
	 *			response="401",
	 *     		description="Unauthorized",
	 *     		@OA\JsonContent(ref="#components/schemas/ResponseFail")
	 * 		),
	 * 		@OA\Response(
	 *			response="406",
	 *     		description="Precondition failed - Invalid Data",
	 *     		@OA\JsonContent(ref="#components/schemas/ResponseFail")
	 * 		)
	 *)
	 */
	public function getPersonalDetails_get()
	{

		$this->load->model('ClientModel');
		$this->load->model('Responses/ResponseClientPersonalDetails');

		//Load Client Data into a class
		$this->ClientModel->loadClientByID($this->JWTAccessToken->getID());
		//check if we have client with that email
		if($this->ClientModel->getDataIsLoaded() === false){
			$this->ResponseFail->status = 'fail';
			$this->ResponseFail->errors = ['error' =>'Invalid Data'];
			$this->response($this->ResponseFail->getDataArray(), $this::HTTP_NOT_ACCEPTABLE, true);
		}

		// generate refresh token and access token and store into database
		$this->ResponseClientPersonalDetails->setData($this->ClientModel);

		// return response
		$this->response(
			$this->ResponseClientPersonalDetails->getData()
			, $this::HTTP_OK,
			true
		);
	}
}
