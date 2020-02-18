<?php defined('BASEPATH') OR exit('No direct script access allowed');

class OAuthClientTokensModel extends OAuthClientTokensRecordSet
{

	public function generateRefreshAndAccessTokens(ClientModel $clientModel){

		$this->load->library('Authorization_Token');

		$this->setClientId($clientModel->getId());
		$this->setAccessToken($this->authorization_token->generateAccessToken($clientModel));
		$this->setRefreshToken(generate_string(100));
		$this->setScope($clientModel->getScope());
		$this->setCreatedAt($this->authorization_token->refreshTokenCreatedAt());
		$this->setValidTo($this->authorization_token->refreshTokenExpireTime());
		$this->setBrowser($this->agent->browser());
		$this->setBrowserVersion($this->agent->version());
		$this->setDeviceName($this->agent->agent_string());
		$this->setIPAdress($this->input->ip_address());
		$this->insertOauthTokenData();
	}

	public function generateNewAccessTokens(ClientModel $clientModel){

		$this->load->library('Authorization_Token');
		$this->setAccessToken($this->authorization_token->generateAccessToken($clientModel));
		$this->setRefreshToken(generate_string(100));
		$this->setValidTo($this->authorization_token->refreshTokenExpireTime());
		$this->setCreatedAt($this->authorization_token->refreshTokenCreatedAt());
		$this->setScope(json_encode($clientModel->getScope()));
		$this->updateOauthTokenData();
	}


}


