<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class BpsService
{
    protected $client;
    protected $baseUrl;
    protected $clientId;
    protected $clientSecret;
    protected $tokenUrl;
    protected $apiUrl;
    protected $accessToken;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = env('KEYCLOAK_BASE_URL');
        $this->clientId = env('KEYCLOAK_CLIENT_ID');
        $this->clientSecret = env('KEYCLOAK_CLIENT_SECRET');
        $this->tokenUrl = $this->baseUrl . 'realms/pegawai-bps/protocol/openid-connect/token';
        $this->apiUrl = $this->baseUrl . 'realms/pegawai-bps/api-pegawai';
    }

    public function getAccessToken()
    {
        try {
            $response = $this->client->post($this->tokenUrl, [
                'form_params' => [
                    'grant_type' => 'client_credentials',
                ],
                'auth' => [$this->clientId, $this->clientSecret],
            ]);

            $data = json_decode($response->getBody(), true);
            $this->accessToken = $data['access_token'];
        } catch (RequestException $e) {
            throw new \Exception("Error getting access token: " . $e->getMessage());
        }
    }

    public function getPegawaiByUsername($username)
    {

        //
        if (empty(session('keycloak_user')['token'])) {
            $this->getAccessToken();
        }else{
            $this->accessToken=session('keycloak_user')['token'];
            //dd(session('keycloak_user')['token']);
        }

        $query = "/username/{$username}";
        //dd($this->apiUrl . $query.$this->baseUrl);
        
        try {
            $response = $this->client->get($this->apiUrl . $query, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->accessToken,
                ],
            ]);
            //dd(session('keycloak_user')['token']);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            throw new \Exception("Error getting pegawai data: " . $e->getMessage());
        }
    }
}
