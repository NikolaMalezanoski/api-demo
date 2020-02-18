<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class CityRecordSet extends CityAbstract
{

	/**
	 * @return array
	 */
	public function getCities(){
		$result = [];
		$this->db
			->select('cit_id as id')
			->select('cit_name as name')
			->select('cit_post_code as postcode')
			->from($this->tableName);

		$query = $this->db->get();
		if ($query->num_rows() > 0){
			$result = $query->result_array();
		}

		$query->free_result();

		return $result;
	}

}
