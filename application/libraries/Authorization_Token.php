<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *   Authorization_Token
 * -------------------------------------------------------------------
 * API Token Check and Generate
 *
 * @author: Nikola Malezanoski
 * @version: 0.0.1
 */

require_once APPPATH . 'third_party/php-jwt/JWT.php';
require_once APPPATH . 'third_party/php-jwt/BeforeValidException.php';
require_once APPPATH . 'third_party/php-jwt/ExpiredException.php';
require_once APPPATH . 'third_party/php-jwt/SignatureInvalidException.php';


class Authorization_Token
{
    /**
     * Token Key
     */
    protected $token_key;

    /**
     * Token algorithm
     */
    protected $token_algorithm;

    /**
     * Request Header Name
     */
    protected $token_header = ['authorization','Authorization'];

    /**
     * Token Expire Time in seconds
     * ----------------------
     * ( 1 Day ) : 60 * 60 * 24 = 86400
     * ( 1 Hour ) : 60 * 60     = 3600
     */
    protected $token_expire_time = 60;

	/**
	 * Token Expire Time
	 * ----------------------
	 * ( 1 Week ) : 7 * 60 * 60 * 24 = 604800‬
	 * ( 1 Day ) : 60 * 60 * 24 = 86400
	 * ( 1 Hour ) : 60 * 60     = 3600
	 */
	protected $refresh_token_expire_time = REFRESH_TOKEN_EXPIRE_TIME;


    public function __construct()
    {
        $this->CI =& get_instance();

        /**
         * jwt config file load
         */
        $this->CI->load->config('jwt');

        /**
         * Load Config Items Values
         */
        $this->token_key        = $this->CI->config->item('jwt_key');
        $this->token_algorithm  = $this->CI->config->item('jwt_algorithm');
    }

    /**
     * Generate Token
     * @param: user data
     */
    public function generateAccessToken(ClientModel $clientModel)
    {
    	$this->CI->load->model('JWTAccessToken');
    	$this->CI->JWTAccessToken->id = $clientModel->getId();
    	$this->CI->JWTAccessToken->email = $clientModel->getEmail();
    	$this->CI->JWTAccessToken->firstName = $clientModel->getFirstName();
    	$this->CI->JWTAccessToken->time = time();
    	$this->CI->JWTAccessToken->exp = time() + $this->token_expire_time;
    	$this->CI->JWTAccessToken->scope = $clientModel->getScope();

        try {
            return JWT::encode($this->CI->JWTAccessToken->getDataArray(), $this->token_key,  $this->token_algorithm);
        }
        catch(Exception $e) {
            return 'Message: ' .$e->getMessage();
        }
    }


	/**
	 * Generate Refresh TOken
	 */
	public function generateRefreshToken()
	{
			return generate_string(100);
	}

	/**
	 * Generate Refresh TOken
	 */
	public function refreshTokenExpireTime()
	{
		return time() + $this->refresh_token_expire_time;
	}

	/**
	 * Generate Refresh TOken
	 */
	public function refreshTokenCreatedAt()
	{
		return time() ;
	}

    /**
     * Validate Token with Header
     * @return : user informations
     */
    public function validateToken()
    {
        /**
         * Request All Headers
         */
        $headers = $this->CI->input->request_headers();

        /**
         * Authorization Header Exists
         */
        $token_data = $this->tokenIsExist($headers);
        if($token_data['status'] === TRUE)
        {
            try
            {
                /**
                 * Token Decode
                 */
                try {
                    $token_decode = JWT::decode($headers[$token_data['key']], $this->token_key, array($this->token_algorithm));
                }

                catch(Exception $e) {
                    return ['status' => FALSE, 'message' => $e->getMessage()];
                }

                if(!empty($token_decode) AND is_object($token_decode))
                {
                    // Check User ID (exists and numeric)
                    if(empty($token_decode->id) OR !is_numeric($token_decode->id))
                    {
                        return ['status' => FALSE, 'message' => 'User ID Not Define!'];

                        // Check Token Time
                    }else if(empty($token_decode->time OR !is_numeric($token_decode->time))) {

                        return ['status' => FALSE, 'message' => 'Token Time Not Define!'];
                    }
                    else
                    {
                        /**
                         * Check Token Time Valid
                         */
                        $time_difference = strtotime('now') - $token_decode->time;
                        if( $time_difference >= $this->token_expire_time )
                        {
                            return ['status' => FALSE, 'message' => 'Token Time Expire.'];

                        }else
                        {
                            /**
                             * All Validation False Return Data
                             */
                            return ['status' => TRUE, 'data' => $token_decode];
                        }
                    }

                }else{
                    return ['status' => FALSE, 'message' => 'Forbidden'];
                }
            }
            catch(Exception $e) {
                return ['status' => FALSE, 'message' => $e->getMessage()];
            }
        }else
        {
            // Authorization Header Not Found!
            return ['status' => FALSE, 'message' => $token_data['message'] ];
        }
    }

    /**
     * Validate Token with POST Request
     */
    public function validateTokenPost()
    {
        if(isset($_POST['token']))
        {
            $token = $this->CI->input->post('token', TRUE);
            if(!empty($token) AND is_string($token) AND !is_array($token))
            {
                try
                {
                    /**
                     * Token Decode
                     */
                    try {
                        $token_decode = JWT::decode($token, $this->token_key, array($this->token_algorithm));
                    }
                    catch(Exception $e) {
                        return ['status' => FALSE, 'message' => $e->getMessage()];
                    }

                    if(!empty($token_decode) AND is_object($token_decode))
                    {
                        // Check User ID (exists and numeric)
                        if(empty($token_decode->id) OR !is_numeric($token_decode->id))
                        {
                            return ['status' => FALSE, 'message' => 'User ID Not Define!'];

                            // Check Token Time
                        }else if(empty($token_decode->time OR !is_numeric($token_decode->time))) {

                            return ['status' => FALSE, 'message' => 'Token Time Not Define!'];
                        }
                        else
                        {
                            /**
                             * Check Token Time Valid
                             */
                            $time_difference = strtotime('now') - $token_decode->time;
                            if( $time_difference >= $this->token_expire_time )
                            {
                                return ['status' => FALSE, 'message' => 'Token Time Expire.'];

                            }else
                            {
                                /**
                                 * All Validation False Return Data
                                 */
                                return ['status' => TRUE, 'data' => $token_decode];
                            }
                        }

                    }else{
                        return ['status' => FALSE, 'message' => 'Forbidden'];
                    }
                }
                catch(Exception $e) {
                    return ['status' => FALSE, 'message' => $e->getMessage()];
                }
            }else
            {
                return ['status' => FALSE, 'message' => 'Token is not defined2.' ];
            }
        } else {
            return ['status' => FALSE, 'message' => 'Token is not defined3.'];
        }
    }

    /**
     * Token Header Check
     * @param: request headers
     * @return array
     */
    public function tokenIsExist($headers)
    {
        if(!empty($headers) AND is_array($headers)) {
            foreach ($this->token_header as $key) {
                if (array_key_exists($key, $headers) AND !empty($key))
                    return ['status' => TRUE, 'key' => $key];
            }
        }
        return ['status' => FALSE, 'message' => 'Token is not defined',json_encode($headers)];
    }

    /**
     * Fetch User Data
     * -----------------
     * @param: token
     * @return: JWTAccessToken
     */
    public function userData()
    {
        /**
         * Request All Headers
         */
        $headers = $this->CI->input->request_headers();

        /**
         * Authorization Header Exists
         */
        $token_data = $this->tokenIsExist($headers);
        if($token_data['status'] === TRUE)
        {
            try
            {
                /**
                 * Token Decode
                 */
                try {
                    $token_decode = JWT::decode($headers[$token_data['key']], $this->token_key, array($this->token_algorithm));
                }
                catch(Exception $e) {
                    return ['status' => FALSE, 'message' => $e->getMessage()];
                }

                if(!empty($token_decode) AND is_object($token_decode))
                {
                	/** @var JWTAccessToken */
                    return $token_decode;
                }else{
                    return ['status' => FALSE, 'message' => 'Forbidden'];
                }
            }
            catch(Exception $e) {
                return ['status' => FALSE, 'message' => $e->getMessage()];
            }
        }else
        {
            // Authorization Header Not Found!
            return ['status' => FALSE, 'message' => $token_data['message'] ];
        }
    }
}
