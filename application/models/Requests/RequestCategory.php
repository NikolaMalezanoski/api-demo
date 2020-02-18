<?php

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     required={"name"}
 * )
 */
class RequestCategory
{

	/**
	 * @OA\Property(type="integer",  example="0" )
	 * @var string
	 */
	public $parent;

	/**
	 * @OA\Property(type="string", example="Лимар" )
	 * @var string
	 */
	public $name;

	/**
	 * @OA\Property(type="string", example="се од лимарија во васио дом" )
	 * @var string
	 */
	public $slug;

	/**
	 * @OA\Property(type="string", example="Лимар, limar" )
	 * @var array
	 */

	public $tags;


	public function getDataArray(){
		return [
			"parent" => $this->parent,
			"name" => $this->name,
			"slug" => $this->slug,
			"tags" => $this->tags
		];
	}

	public function loadData($data){
		if (is_array($data) && array_key_exists("parent", $data )){
			$this->parent = $data['parent'];
		}
		if (is_array($data) && array_key_exists("name", $data )){
			$this->name = $data['name'];
		}
		if (is_array($data) && array_key_exists("slug", $data )){
			$this->slug = $data['slug'];
		}
		if (is_array($data) && array_key_exists("tags", $data )){
			$this->tags = $data['tags'];
		}

	}
}
