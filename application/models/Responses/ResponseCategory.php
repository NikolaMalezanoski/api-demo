<?php defined('BASEPATH') OR exit('No direct script access allowed');

use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
class ResponseCategory
{

	/**
	 * @OA\Property(type="integer" )
	 * @var string
	 */
	public $id;

	/**
	 * @OA\Property(type="integer" )
	 * @var string
	 */
	public $parent;

	/**
	 * @OA\Property(type="string" )
	 * @var string
	 */
	public $name;

	/**
	 * @OA\Property(type="string" )
	 * @var string
	 */
	public $slug;
	/**
	 * @OA\Property(type="string" )
	 * @var array
	 */

	public $tags;


	public function setData(CategoryRecordSet $CategoryRecordSet){


			$this->id =  $CategoryRecordSet->getId();
			$this->parent =  $CategoryRecordSet->getParent();
			$this->name =  $CategoryRecordSet->getName();
			$this->slug =  $CategoryRecordSet->getSlug();
			$this->tags =  $CategoryRecordSet->getTags();

	}

	public function getData(){

		return [
			'id' =>  $this->id,
			'parent' =>  $this->firstName,
			'name' =>  $this->email,
			'slug' =>  $this->emailVerified,
			'tags' =>  $this->scope,
		];
	}
}
