<?php
defined('BASEPATH') OR exit('No direct script access allowed');

abstract  class ClientAbstract extends CI_Model
{
	protected $tableName = 'client_cli';

	protected $cli_id;
	protected $cli_email;
	protected $cli_password;
	protected $cli_first_name;
	protected $cli_email_verified;
	protected $cli_token_for_email_verification;
	protected $cli_token_for_reset_password;
	protected $cli_scope;

	protected $data_loaded = false;

	public function setId($var)
	{
		$this->cli_id = $var;
	}

	public function getId()
	{
		return $this->cli_id;
	}

	public function setEmail($var)
	{
		$this->cli_email = $var;
	}

	public function getEmail()
	{
		return $this->cli_email;
	}

	public function setPassword($var)
	{
		$this->cli_password = $var;
	}

	public function getPassword()
	{
		return $this->cli_password;
	}

	public function setFirstName($var)
	{
		$this->cli_first_name = $var;
	}

	public function getFirstName()
	{
		return $this->cli_first_name;
	}

	public function setEmailVerified($var)
	{
		$this->cli_email_verified = $var;
	}

	public function getEmailVerified()
	{
		return $this->cli_email_verified;
	}

	public function setTokenForEmailVerification($var)
	{
		$this->cli_token_for_email_verification = $var;
	}

	public function getTokenForEmailVerification()
	{
		return $this->cli_token_for_email_verification;
	}


	public function setTokenForResetPassword($var)
	{
		$this->cli_token_for_reset_password = $var;
	}

	public function getTokenForResetPassword()
	{
		return $this->cli_token_for_reset_password;
	}

	public function setScope($var)
	{
		$this->cli_scope = json_encode($var);
	}

	public function getScope()
	{
		return json_decode($this->cli_scope);
	}

	public function setDataIsLoaded($var)
	{
		$this->data_loaded = $var;
	}

	public function getDataIsLoaded()
	{
		return $this->data_loaded;
	}

	abstract public function loadClientByID($clientID);
	abstract public function loadClientByEmail($clientEmail);
	abstract public function loadClientByResetPasswordToken($clientEmail);
}
