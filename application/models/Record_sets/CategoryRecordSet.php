<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class CategoryRecordSet extends CategoryAbstract
{

	public function insertCategory(){
		$this->db
			->set('cat_parent', $this->getParent())
			->set('cat_name', $this->getName())
			->set('cat_slug', $this->getSlug())
			->set('cat_tags', $this->getTags())
			->set('cat_created_at', 'now()', false)
			->set('cat_updated_at',null )

			->insert($this->tableName);
		$insertedID = $this->db->insert_id();
		return $insertedID;
	}

	public function updateCategory(){
		if ($this->getId() > 0) {
			$this->db
				->set('cat_parent', $this->getParent())
				->set('cat_name', $this->getName())
				->set('cat_slug', $this->getSlug())
				->set('cat_tags', $this->getTags())
				->set('cat_updated_at','now()', false )

				->where('cat_id', $this->getId())

				->update($this->tableName);
			return  $this->db->affected_rows() > 0 ? true: false ;
		} else {
			return false;
		}
	}
	public function deleteCategory(){
		if ($this->getId() > 0) {
			$this->db
				->where('cat_id', $this->getId())
				->delete($this->tableName);
			return  $this->db->affected_rows() > 0 ? true: false ;
		} else {
			return false;
		}
	}

	/**
	 * @param string $searchByTag
	 * @return array
	 */
	public function getAllCategories($searchByTag = ''){
		$result = [];

		$this->db
			->select('cat_id as id')
			->select('cat_parent as parent')
			->select('cat_name as name')
			->select('cat_slug as slug')
			->select('cat_tags as tags')
			->from($this->tableName);

		if (!empty($searchByTag)){
			$this->db->like('cat_name', $searchByTag)
				->or_like('cat_tags', $searchByTag);
		}

		$query = $this->db->get();
		if ($query->num_rows() > 0){
			$result = $query->result_array();
		}

		$query->free_result();

		return $result;
	}

	/**
	 * @param integer $categoryID
	 */
	public function loadCategoryByID($categoryID){
		if (empty($categoryID)){
			return;
		}

		$query = $this->db->select('*')
			->from($this->tableName)
			->where('cat_id', $categoryID)
			->get();
		if ($query->num_rows() > 0){
			$result = $query->custom_row_object(0, 'CategoryRecordSet');
			$this->refreshAll($result);
		} else {
			$this->resetAll();
		}
		$query->free_result();
	}


	public function getData(){

		return [
			'id' =>  $this->getId(),
			'parent' =>  $this->getParent(),
			'name' =>  $this->getName(),
			'slug' =>  $this->getSlug(),
			'tags' =>  $this->getTags(),
		];
	}

	public function setAllData(RequestCategory $RequestCategory){

		$this->setParent($RequestCategory->parent);
		$this->setName($RequestCategory->name);
		$this->setSlug($RequestCategory->slug);
		$this->setTags($RequestCategory->tags);
	}


	protected function resetAll(){
		$this->setId( null );
		$this->setParent(null);
		$this->setName(null);
		$this->setSlug(null);
		$this->setTags(null);
		$this->setCreatedAt(null);
		$this->setUpdatedAt(null);

		$this->setDataIsLoaded(false);
	}

	protected function refreshAll( CategoryRecordSet $data){
		$this->setId($data->getId());
		$this->setParent($data->getParent());
		$this->setName($data->getName());
		$this->setSlug($data->getSlug());
		$this->setTags($data->getTags());
		$this->setCreatedAt($data->getCreatedAt());
		$this->setUpdatedAt($data->getUpdatedAt());

		$this->setDataIsLoaded(true);
	}



}
