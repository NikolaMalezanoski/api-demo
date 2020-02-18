<?php defined('BASEPATH') OR exit('No direct script access allowed');

use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
class ResponseCity
{

	/**
	 * @OA\Property(type="integer" )
	 * @var string
	 */
	public $id;

	/**
	 * @OA\Property(type="string" )
	 * @var string
	 */
	public $name;

	/**
	 * @OA\Property(type="string" )
	 * @var string
	 */
	public $postcode;

}
