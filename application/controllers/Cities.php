<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use OpenApi\Annotations as OA;

class Cities extends API_Controller
{
	public function __construct()
	{
		parent::__construct();

	}

	/**
	 * @OA\Get(
	 *     path="/cities",
	 *     operationId="get_city",
	 *     summary="List cities",
	 *     description="List cities",
	 *     tags={"City"},
	 *     @OA\Response(
	 *			response="200",
	 *     		description="Array list of cities",
	 *     		@OA\JsonContent(
	 *          	type="array",
	 *            	@OA\Items(ref="#components/schemas/ResponseCity")
	 *         	)
	 * 		)
	 *)
	 */
	public function index_get(){

		$this->load->model('CityModel');

		$this->response(
			$this->CityModel->getCities()
			, $this::HTTP_OK,
			true
		);
	}
}
