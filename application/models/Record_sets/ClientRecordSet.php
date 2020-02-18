<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class ClientRecordSet  extends ClientAbstract
{

	/**
	 * @param $clientID
	 */
	public function loadClientByID($clientID){
		$query = $this->db->select('*')
			->from($this->tableName)
			->where('cli_id', $clientID)
			->get();

		if ($query->num_rows() > 0){
			$result = $query->custom_row_object(0, 'ClientRecordSet');
			$this->refreshAll($result);
		} else {
			$this->resetAll();
		}
		$query->free_result();
	}

	public function loadClientByEmail($clientEmail)
	{
		$query = $this->db->select('*')
			->from($this->tableName)
			->where('cli_email', $clientEmail)
			->get();
		if ($query->num_rows() > 0){
			$result = $query->custom_row_object(0, 'ClientRecordSet');
			$this->refreshAll($result);
		} else {
			$this->resetAll();
		}
		$query->free_result();
	}

	public function loadClientByResetPasswordToken($resetPasswordToken)
	{
		if (empty($resetPasswordToken)){
			return;
		}

		$query = $this->db->select('*')
			->from($this->tableName)
			->where('cli_token_for_reset_password', $resetPasswordToken)
			->get();
		if ($query->num_rows() > 0){
			$result = $query->custom_row_object(0, 'ClientRecordSet');
			$this->refreshAll($result);
		} else {
			$this->resetAll();
		}
		$query->free_result();
	}


	public function insertClient()
	{

		$this->db->set('cli_email', $this->getEmail())
			->set('cli_password', $this->getPassword())
			->set('cli_first_name', $this->getFirstName())
			->set('cli_email_verified', $this->getEmailVerified())
			->set('cli_token_for_email_verification', $this->getTokenForEmailVerification())
			->set('cli_token_for_reset_password', $this->getTokenForResetPassword())
			->set('cli_scope', !empty($this->getScope())?
				json_encode($this->getScope()) :
				json_encode(['client','super-admin'])
			)
			->insert($this->tableName);
		$insertedID = $this->db->insert_id();
		return $insertedID;

	}

	public function updateClient()
	{
		if ($this->getId() > 0) {
			 $this->db->set('cli_email', $this->getEmail())
					->set('cli_password', $this->getPassword())
					->set('cli_first_name', $this->getFirstName())
					->set('cli_email_verified', $this->getEmailVerified())
					->set('cli_token_for_email_verification', $this->getTokenForEmailVerification())
					->set('cli_token_for_reset_password', $this->getTokenForResetPassword())
					->set('cli_scope', json_encode($this->getScope()))
					->where('cli_id', $this->getId())
					->update($this->tableName);
			return  $this->db->affected_rows()>0 ? true: false ;
		} else {
			return false;
		}

	}

	private function refreshAll( ClientRecordSet $data){
		$this->setId($data->getId());
		$this->setEmail($data->getEmail());
		$this->setFirstName($data->getFirstName());
		$this->setPassword($data->getPassword());
		$this->setEmailVerified($data->getEmailVerified());
		$this->setTokenForEmailVerification($data->getTokenForEmailVerification());
		$this->setTokenForResetPassword($data->getTokenForResetPassword());
		$this->setTokenForResetPassword($data->getTokenForResetPassword());
		$this->setScope($data->getScope());

		$this->setDataIsLoaded(true);
	}

	private function resetAll(){
		$this->setId(null);
		$this->setEmail(null);
		$this->setFirstName(null);
		$this->setPassword(null);
		$this->setEmailVerified(null);
		$this->setTokenForEmailVerification(null);
		$this->setTokenForResetPassword(null);
		$this->setTokenForResetPassword(null);
		$this->setDataIsLoaded(false);
		$this->setScope(null);
	}
}
