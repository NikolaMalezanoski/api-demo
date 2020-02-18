<?php
defined('BASEPATH') OR exit('No direct script access allowed');

abstract class CategoryAbstract extends CI_Model
{
	protected $tableName = 'category_cat';

	protected $cat_id;
	protected $cat_parent;
	protected $cat_name;
	protected $cat_slug;
	protected $cat_tags;
	protected $cat_created_at;
	protected $cat_updated_at;

	protected $data_loaded = false;

	public function setId($var)
	{
		$this->cat_id = $var;
	}

	public function getId()
	{
		return $this->cat_id;
	}

	public function setParent($var)
	{
		$this->cat_parent = $var;
	}

	public function getParent()
	{
		return $this->cat_parent;
	}

	public function setName($var)
	{
		$this->cat_name = $var;
	}

	public function getName()
	{
		return $this->cat_name;
	}

	public function setSlug($var)
	{
		$this->cat_slug = $var;
	}

	public function getSlug()
	{
		return $this->cat_slug;
	}

	public function setTags($var)
	{
		$this->cat_tags = $var;
	}

	public function getTags()
	{
		return $this->cat_tags;
	}

	public function setCreatedAt($var)
	{
		$this->cat_created_at = $var;
	}

	public function getCreatedAt()
	{
		return $this->cat_created_at;
	}

	public function setUpdatedAt($var)
	{
		$this->cat_updated_at = $var;
	}

	public function getUpdatedAt()
	{
		return $this->cat_updated_at;
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
