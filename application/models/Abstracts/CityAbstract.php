<?php
defined('BASEPATH') OR exit('No direct script access allowed');

abstract class CityAbstract extends CI_Model
{
	protected $tableName = 'city_cit';

	protected $cit_id;
	protected $cit_name;
	protected $cit_post_code;


	protected $data_loaded = false;

	public function setId($var)
	{
		$this->cit_id = $var;
	}

	public function getId()
	{
		return $this->cit_id;
	}

	public function setName($var)
	{
		$this->cit_name = $var;
	}

	public function getName()
	{
		return $this->cit_name;
	}

	public function setPostCode($var)
	{
		$this->cit_post_code = $var;
	}

	public function getPostCode()
	{
		return $this->cit_post_code;
	}

	public function setDataIsLoaded($var)
	{
		$this->data_loaded = $var;
	}

	public function getDataIsLoaded()
	{
		return $this->data_loaded;
	}

}
