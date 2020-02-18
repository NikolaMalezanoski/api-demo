<?php
defined('BASEPATH') OR exit('No direct script access allowed');

abstract  class OAuthClientTokensAbstract extends CI_Model
{
	protected $tableName = 'oauth_client_tokens_oauth';

	protected $oauth_id;
	protected $oauth_id_link_cli;
	protected $oauth_access_token;
	protected $oauth_refresh_token;
	protected $oauth_scope;
	protected $oauth_created_at;
	protected $oauth_valid_to;
	protected $oauth_ip_address;
	protected $oauth_device_name;
	protected $oauth_browser;
	protected $oauth_browser_version;

	protected $data_loaded = false;

	public function setId($var)
	{
		$this->oauth_id = $var;
	}

	public function getId()
	{
		return $this->oauth_id;
	}

	public function setClientId($var)
	{
		$this->oauth_id_link_cli = $var;
	}

	public function getClientId()
	{
		return $this->oauth_id_link_cli;
	}

	public function setAccessToken($var)
	{
		$this->oauth_access_token = $var;
	}

	public function getAccessToken()
	{
		return $this->oauth_access_token;
	}

	public function setRefreshToken($var)
	{
		$this->oauth_refresh_token = $var;
	}

	public function getRefreshToken()
	{
		return $this->oauth_refresh_token;
	}

	public function setScope($var)
	{
		$this->oauth_scope = json_encode($var);
	}

	public function getScope()
	{
		return json_decode($this->oauth_scope);
	}

	public function setCreatedAt($var)
	{
		$this->oauth_created_at = $var;
	}

	public function getCreatedAt()
	{
		return $this->oauth_created_at;
	}


	public function setValidTo($var)
	{
		$this->oauth_valid_to = $var;
	}

	public function getValidTo()
	{
		return $this->oauth_valid_to;
	}

	public function setIPAdress($var)
	{
		$this->oauth_ip_address = $var;
	}

	public function getIPAddress()
	{
		return $this->oauth_ip_address;
	}

	public function setDeviceName($var)
	{
		$this->oauth_device_name = $var;
	}

	public function getDeviceName()
	{
		return $this->oauth_device_name;
	}

	public function setBrowser($var)
	{
		$this->oauth_browser = $var;
	}

	public function getBrowser()
	{
		return $this->oauth_browser;
	}

	public function setBrowserVersion($var)
	{
		$this->oauth_browser_version = $var;
	}

	public function getBrowserVersion()
	{
		return $this->oauth_browser_version;
	}

		public function setDataIsLoaded($var)
	{
		$this->data_loaded = $var;
	}

	public function getDataIsLoaded()
	{
		return $this->data_loaded;
	}

	abstract public function loadOauthDataByAccessToken($accessToken);
	abstract public function loadOauthDataByRefreshToken($refreshTOken);
}
