<?php

namespace App\Services\ZohoAPI;

use Exception;
use Illuminate\Support\Facades\Http;

class Service
{
    protected string $baseUrl;
    protected string $baseApiUrl;
    protected string $clientId;
    protected string $clientSecret;
    protected string $refreshToken;
    protected string $accessToken;

//    TODO подумати над зберіганням даних в БД
    public function __construct()
    {
        $this->baseUrl = config('services.zoho.base_url');
        $this->baseApiUrl = config('services.zoho.api_base_url');
        $this->clientId = config('services.zoho.client_id');
        $this->clientSecret = config('services.zoho.client_secret');
        $this->refreshToken = config('services.zoho.refresh_token');
        $this->accessToken = config('services.zoho.access_token');
    }

    /**
     * @throws Exception
     */
    public function createAccount(array $data): array
    {
        return $this->sendRequest('crm/v2/Accounts', ['data' => [$data]]);
    }

    /**
     * @throws Exception
     */
    public function createDeal(array $data): array
    {
        return $this->sendRequest('crm/v2/Deals', ['data' => [$data]]);
    }

    /**
     * @throws Exception
     */
    public function refreshToken(): void
    {

        $refreshToken = $this->refreshToken;
        $clientId = $this->clientId;
        $clientSecret = $this->clientSecret;

        $response = Http::withoutVerifying() // ахутенг SSL
        ->post("$this->baseUrl/oauth/v2/token?refresh_token=$refreshToken&client_id=$clientId&client_secret=$clientSecret&grant_type=refresh_token")->json();

        if (isset($response['access_token'])) {
            $this->accessToken = $response['access_token'];
        } else {
            throw new Exception('Не вдалося оновити токен: ' . json_encode($response));
        }
    }

    /**
     * @throws Exception
     */
    private function sendRequest(string $endpoint, array $data = [], bool $retry = true): array
    {
        $headers = [];
        $headers = array_merge([
            'Content-Type' => 'application/json',
            'Authorization' => 'Zoho-oauthtoken ' . $this->accessToken,
        ], $headers);

        try {
            $response = Http::withoutVerifying()
                ->withHeaders($headers)
                ->post("$this->baseApiUrl/$endpoint", $data)
                ->json();

            if (isset($response['code']) && $response['code'] === 'INVALID_TOKEN' && $retry) {
                $this->refreshToken();

                return $this->sendRequest($endpoint, $data, false);
            }

            if (isset($response['code']) && $response['code'] !== 'SUCCESS') {
                throw new Exception('Помилка API Zoho: ' . json_encode($response));
            }

            return $response;
        } catch (Exception $e) {
            throw new Exception('Помилка запиту: ' . $e->getMessage());
        }
    }
}
