<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
use \Firebase\JWT\JWT;

include $_SERVER['DOCUMENT_ROOT'] . '/config.php';
$secretFileURL = $_SERVER['DOCUMENT_ROOT'] . '/file/secret.json';
$secretFileString = file_get_contents( $secretFileURL, FILE_USE_INCLUDE_PATH );
$secretFile = json_decode($secretFileString, true);

$privateKey = $secretFile[ "private_key" ];


class ApiLinebertyHandler {

    /**
     * Get an api KEY to use Lineberty
     */
    public function getApiKey () {
        syslog( LOG_INFO, 'Get an api key \n' );

        $url = '/api_key';

        return $this->runRequest($url, 'GET', null);
    }

    /**
     * Create a Lineberty user
     */
    public function createUser () {
        syslog( LOG_INFO, 'Create a Lineberty User \n' );

        $url = '/users';

        return $this->runRequest($url, 'POST', null);
    }

    /**
     * Log in a specific user on Lineberty
     * @param {string} $userId
     */
    public function loginUser ($userId) {
        syslog( LOG_INFO, 'Log a user with userId = "' . $userId . '" \n' );

        $url = '/users/' . $userId . '/login';

        return $this->runRequest($url, 'GET', null);
    }

    /**
     * Refresh the token of a sessionId
     * @param {string} $userId
     * @param {string} $sessionId
     */
    public function refreshToken ($userId, $sessionId) {
        syslog( LOG_INFO, 'RefreshToken with userId "' . $userId . '" and sessionId = ' . $sessionId . '\n' );

        $url = '/users/' . $userId . '/session/' . $sessionId . '/refreshToken';

        return $this->runRequest($url, 'GET', null);
    }

    /**
     * @private
     * @return {object} The token
     */
    private function generateToken () {
        global $config, $privateKey, $secretFile;
        $now = time();

        $payload = array (
            'iat' => $now,
            'exp' => $now + 3600,
            'aud'=> 'api.lineberty.net',
            'iss' => $secretFile[ "client_email" ],
            'sub' => 'MyCompany', //company name
            'email' => $secretFile[ "client_email" ]
        );

        return JWT::encode($payload, $privateKey, $config[ "jwt" ][ "algorithm" ]);
    }

    /**
     * @private
     */
    private function runRequest ($url, $method = 'GET', $data) {
        global $config;

        $token = $this->generateToken();

        $entireUrl = $config[ "linebertyUrl" ] . '/' . $config[ "linebertyVersion" ] . $url;

        $ch = curl_init( $entireUrl );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: ' . 'Bearer ' . $token ));

        switch ($method) {
            case 'GET':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                break;
            case 'POST':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                if ( isset( $data ) && !is_null( $data ) ) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                }
                break;
            default:
                throw new Exception('Bad request method');
        }

        try {
            $res = curl_exec($ch);
        } catch (Exception $e) {
            syslog( LOG_ERR, "Request exception : " .  $e->getMessage() . "\n" );
            throw $e;
        }

        curl_close($ch);

        return json_decode($res, true);
    }
}

?>
