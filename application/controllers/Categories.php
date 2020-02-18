<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use OpenApi\Annotations as OA;

class Categories extends API_Controller
{
	public function __construct()
	{
		parent::__construct();

	}

	/**
	 * @OA\Get(
	 *     path="/categories",
	 *     operationId="get_categories",
	 *     summary="List categories  filtered by tags",
	 *     description="List categories  filtered by tags",
	 *     tags={"Category"},
	 *     @OA\Parameter(
	 *          name="find-by-tag",
	 *          description="Find category by tag",
	 *          in="query",
	 *           @OA\Items(type="string"),
	 *      ),
	 *     @OA\Response(
	 *			response="200",
	 *     		description="array list of categories",
	 *     		@OA\JsonContent(
	 *          	type="array",
	 *            	@OA\Items(ref="#components/schemas/ResponseCategory")
	 *         	)
	 * 		)
	 *)
	 * @OA\Get(
	 *     path="/categories/{categoryId}",
	 *     operationId="get_category",
	 *     summary="List category by categoryId",
	 *     description="List category by categoryId",
	 *     tags={"Category"},
	 *     @OA\Parameter(
	 *          name="categoryId",
	 *          description="Category id to be listed",
	 *          in="path",
	 *           @OA\Items(type="integer")
	 *      ),
	 *     @OA\Response(
	 *			response="200",
	 *     		description="categories",
	 *     		@OA\JsonContent(ref="#components/schemas/ResponseCategory")
	 * 		)
	 *)
	 */
	public function index_get($categoryId = null){

		$this->load->model('CategoryModel');
		if ($categoryId === null) {
			$this->returnAllCategories();
		} else {
			$this->returnCategoryById($categoryId);

		}
	}

	/**
	 * @OA\Post(
	 *     path="/categories",
	 *     summary="Create new category",
	 *     description="Create new category",
	 *     tags={"Category"},
	 *     security={{"bearerAuth":{}}},
	 *     @OA\RequestBody(
	 *     		@OA\JsonContent(ref="#components/schemas/RequestCategory")
	 *	 	),
	 *     @OA\Response(
	 *			response="201",
	 *     		description="Insert CAtegory was saccesfull",
	 *          @OA\JsonContent(ref="#components/schemas/ResponseCategory")
	 * 		),
	 * 	   @OA\Response(
	 *			response="401",
	 *     		description="Unauthorized",
	 *     		@OA\JsonContent(ref="#components/schemas/ResponseFail")
	 * 		)
	 *)
	 */
	public function index_post(){
		$this->protectedByJWT();

		$this->load->model('CategoryModel');
		$this->load->model('Requests/RequestCategory');
		$this->load->model('Responses/ResponseFail');
		$this->load->library('Form_validation_category');

		$this->RequestCategory->loadData($this->request->body);
		$this->form_validation_category->registerCategoryValidation($this->RequestCategory);

		if ($this->form_validation_category->getStatus() == false) {
			$this->ResponseFail->status = 'fail';
			$this->ResponseFail->errors = $this->form_validation_category->getErrors();
			$this->response($this->ResponseFail->getDataArray(), $this::HTTP_PRECONDITION_FAILED, true);
		}
		$this->CategoryModel->setAllData($this->RequestCategory);

		$categoryID = $this->CategoryModel->insertCategory();

		//Load Category Data into a class
		$this->CategoryModel->loadCategoryByID($categoryID);

		// return response
		$this->response(
			$this->CategoryModel->getData()
			, $this::HTTP_CREATED,
			true
		);
	}

	/**
	 * @OA\Put(
	 *     path="/categories/{categoryId}",
	 *     summary="Update category by categoryID",
	 *     description="Update category by categoryID",
	 *     tags={"Category"},
	 *     security={{"bearerAuth":{}}},
	 *     @OA\Parameter(
	 *          name="categoryId",
	 *          description="Category id to update",
	 *          in="path",
	 *           @OA\Items(type="integer")
	 *      ),
	 *     @OA\RequestBody(
	 *     		@OA\JsonContent(ref="#components/schemas/RequestCategory")
	 *	 	),
	 *     @OA\Response(
	 *			response="202",
	 *     		description="Category update was accepted",
	 *          @OA\JsonContent(ref="#components/schemas/ResponseCategory")
	 * 		),
	 * 	   @OA\Response(
	 *			response="401",
	 *     		description="Unauthorized",
	 *     		@OA\JsonContent(ref="#components/schemas/ResponseFail")
	 * 		)
	 *)
	 * @param $categoryId integer
	 */
	public function index_put($categoryId = null){
		$this->protectedByJWT();

		$this->load->model('CategoryModel');
		$this->load->model('Requests/RequestCategory');
		$this->load->model('Responses/ResponseFail');
		$this->load->library('Form_validation_category');

		$this->RequestCategory->loadData($this->request->body);
		$this->form_validation_category->registerCategoryValidation($this->RequestCategory);

		if ($this->form_validation_category->getStatus() == false) {
			$this->ResponseFail->status = 'fail';
			$this->ResponseFail->errors = $this->form_validation_category->getErrors();
			$this->response($this->ResponseFail->getDataArray(), $this::HTTP_PRECONDITION_FAILED, true);
		}
		$this->CategoryModel->loadCategoryByID($categoryId);
		if ($this->CategoryModel->getDataIsLoaded() == false) {
			$this->ResponseFail->status = 'fail';
			$this->ResponseFail->errors = ['categoryId'=> 'Can not find category'];
			$this->response($this->ResponseFail->getDataArray(), $this::HTTP_PRECONDITION_FAILED, true);
		}
		$this->CategoryModel->setAllData($this->RequestCategory);
		$this->CategoryModel->setId($categoryId);

		$this->CategoryModel->updateCategory();

		//Load Category Data into a class
		$this->CategoryModel->loadCategoryByID($categoryId);

		// return response
		$this->response(
			$this->CategoryModel->getData()
			, $this::HTTP_ACCEPTED,
			true
		);
	}

	/**
	 * @OA\Delete(
	 *     path="/categories/{categoryId}",
	 *     summary="Delete a category",
	 *     description="Delete Category By CategoryID",
	 *     tags={"Category"},
	 *     security={{"bearerAuth":{}}},
	 *     @OA\Parameter(
	 *          name="categoryId",
	 *          description="Category id to delete",
	 *          in="path",
	 *           @OA\Items(type="integer")
	 *      ),
	 *     @OA\Response(
	 *			response="200",
	 *     		description="array list of categories",
	 *     		@OA\JsonContent(
	 *          	type="array",
	 *            	@OA\Items(ref="#components/schemas/ResponseCategory")
	 *         	)
	 * 		)
	 *)
	 * @param $categoryId integer
	 */
	public function index_delete($categoryId = null){
		$this->protectedByJWT();

		$this->load->model('CategoryModel');
		$this->load->model('Responses/ResponseFail');

		$this->CategoryModel->loadCategoryByID($categoryId);
		if ($this->CategoryModel->getDataIsLoaded() == false) {
			$this->ResponseFail->status = 'fail';
			$this->ResponseFail->errors = ['categoryId'=> 'Can not find category'];
			$this->response($this->ResponseFail->getDataArray(), $this::HTTP_PRECONDITION_FAILED, true);
		}
		$this->CategoryModel->deleteCategory();
		$this->response(
			['status'=>'success']
			, $this::HTTP_OK,
			true
		);
	}

	private function returnAllCategories(): void
	{
		$searchByTag = $this->input->get('find-by-tag', true);
		$this->response(
			$this->CategoryModel->getAllCategories($searchByTag)
			, $this::HTTP_OK,
			true
		);
	}

	/**
	 * @param $categoryId
	 */
	private function returnCategoryById($categoryId): void
	{
		$this->CategoryModel->loadCategoryByID($categoryId);
		if ($this->CategoryModel->getDataIsLoaded() == false) {
			$this->ResponseFail->status = 'fail';
			$this->ResponseFail->errors = ['categoryId' => 'Can not find category'];
			$this->response($this->ResponseFail->getDataArray(), $this::HTTP_PRECONDITION_FAILED, true);
		} else {
			$this->response(
				$this->CategoryModel->getData()
				, $this::HTTP_OK,
				true
			);
		}
	}

}
