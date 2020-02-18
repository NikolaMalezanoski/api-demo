<?php


class OAuthClientTokensRecordSet  extends OAuthClientTokensAbstract
{

	/**
	 * @param $clientID
	 */
	public function loadOauthDataByAccessToken ($accessToken){
		$query = $this->db->select('*')
			->from($this->tableName)
			->where('oauth_access_token', $accessToken)
			->get();

		if ($query->num_rows() > 0){
			$result = $query->custom_row_object(0, 'OAuthClientTokensRecordSet');
			$this->refreshAll($result);
		} else {
			$this->resetAll();
		}
		$query->free_result();
	}

	public function loadOauthDataByRefreshToken ($refreshTOken)
	{
		$query = $this->db->select('*')
			->from($this->tableName)
			->where('oauth_refresh_token', $refreshTOken)
			->get();
		if ($query->num_rows() > 0){
			$result = $query->custom_row_object(0, 'OAuthClientTokensRecordSet');
			$this->refreshAll($result);
		} else {
			$this->resetAll();
		}
		$query->free_result();
	}

	public function insertOauthTokenData()
	{

		$this->db
			->set('oauth_id_link_cli', $this->getClientId())
			->set('oauth_access_token', $this->getAccessToken())
			->set('oauth_refresh_token', $this->getRefreshToken())
			->set('oauth_scope', json_encode($this->getScope()))
			->set('oauth_created_at', $this->getCreatedAt())
			->set('oauth_valid_to', $this->getValidTo())
			->set('oauth_ip_address', $this->getIPAddress())
			->set('oauth_device_name', $this->getDeviceName())
			->set('oauth_browser', $this->getBrowser())
			->set('oauth_browser_version', $this->getBrowserVersion())
			->insert($this->tableName);
		$insertedID = $this->db->insert_id();
		return $insertedID;

	}

	public function updateOauthTokenData()
	{
		if ($this->getId() > 0) {
			$query  = $this->db
				->set('oauth_id_link_cli', $this->getClientId())
				->set('oauth_access_token', $this->getAccessToken())
				->set('oauth_refresh_token', $this->getRefreshToken())
				->set('oauth_scope', json_encode($this->getScope()))
				->set('oauth_created_at', $this->getCreatedAt())
				->set('oauth_valid_to', $this->getValidTo())
				->set('oauth_ip_address', $this->getIPAddress())
				->set('oauth_device_name', $this->getDeviceName())
				->set('oauth_browser', $this->getBrowser())
				->set('oauth_browser_version', $this->getBrowserVersion())
				->where('oauth_id', $this->getId())
				->update($this->tableName);
				return (is_object($query) && $query->affected_rows() > 0);
		} else {
			return false;
		}

	}


	private function refreshAll( OAuthClientTokensRecordSet $data){
		$this->setId($data->getId());
		$this->setClientId($data->getClientId());
		$this->setAccessToken($data->getAccessToken());
		$this->setRefreshToken($data->getRefreshToken());
		$this->setScope($data->getScope());
		$this->setCreatedAt($data->getCreatedAt());
		$this->setValidTo($data->getValidTo());
		$this->setIPAdress($data->getIPAddress());
		$this->setDeviceName($data->getDeviceName());
		$this->setBrowser($data->getDeviceName());
		$this->setBrowserVersion($data->getBrowserVersion());
		$this->setDataIsLoaded(true);
	}

	private function resetAll(){
		$this->setId(null);
		$this->setClientId(null);
		$this->setAccessToken(null);
		$this->setRefreshToken(null);
		$this->setScope(null);
		$this->setCreatedAt(null);
		$this->setValidTo(null);
		$this->setIPAdress(null);
		$this->setDeviceName(null);
		$this->setDataIsLoaded(false);
	}
}
