<?php

namespace App\Services\API;

use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Support\Facades\Http;

class BaseAPIService
{
    const SHA256_WITH_RSA_ENCRYPT = "sha256WithRSAEncryption";

    protected $uuid;

    protected $timestamp;

    public function __construct($time, $uuid)
    {
        $this->uuid = $uuid;
        $this->timestamp = $time;
    }

    /**
     * Handle http request
     *
     * @param string $method
     * @param string $api_path
     * @param array $data
     * @return Http
     */
    protected function handleHeraApi(string $method, string $api_path, array $data = [])
    {
        $method = strtoupper($method);

        $api_path = strtolower($api_path);

        $url = env('HERA_PLAY_API') . $api_path;

        $signature = $this->signature($method, $api_path);

        $auth_header = $this->headers($signature);
        $response = Http::withHeaders($auth_header)->{$method}($url, $data);

        return $response;
    }

    /**
     * Handle mini game http request
     *
     * @param string $method
     * @param string $api_path
     * @param array $data
     * @return Http
     */
    protected function handleCallApi(string $method, string $url, array $data = [], array $headers = [])
    {
        $method = strtoupper($method);

        $headers = [
            'Content-Type' => 'application/json',
            ...$headers,
        ];
        $response = Http::withHeaders($headers)->{$method}($url, $data);

        return $response;
    }

    /**
     * Signature send to hera server
     *
     * @param string $method
     * @param string $api_path
     * @return string
     */
    protected function signature(string $method, string $api_path): string
    {
        $timestamp = $this->timestamp;

        $data_to_encrypt = sprintf('%s %s %u %s', $method, strtolower($api_path), $timestamp, $this->uuid);

        $private_key_file_path = storage_path('/encrypt_keys/private_key.pem');

        $private_key = openssl_pkey_get_private(file_get_contents($private_key_file_path));

        openssl_sign($data_to_encrypt, $signature, $private_key, self::SHA256_WITH_RSA_ENCRYPT);

        $signature_base64 = base64_encode($signature);

        return $signature_base64;
    }

    /**
     * Undocumented function
     *
     * @param string $signature
     * @return array
     */
    protected function headers(string $signature): array
    {
        $authorization = sprintf('%s %s,%u,%s,%s', env('HERA_AUTH_TYPE'), env('HERA_AGENT_CODE'), $this->timestamp, $this->uuid, $signature);

        $headers = [
            'Authorization' => $authorization,
            'Accept' => 'application/json',
        ];

        return $headers;
    }

    /**
     * Verify auth header
     *
     * @param \Request $request
     * @return boolean
     */
    public function verifyAuthHeader($request): bool
    {
        $api_path = strtolower($request->route()->getName());
        $http_method = strtoupper($request->method());
        $auth_header = $request->header('Authorization');

        if (!isset($api_path) || !$auth_header) {
            return false;
        }

        $parts = explode(' ', $auth_header);
        if (count($parts) != 2) {
            return false;
        }

        if ($parts[0] != env('HERA_AUTH_TYPE')) {
            return false;
        }

        $auth_params = explode(',', $parts[1]);
        if (count($auth_params) != 4) {
            return false;
        }

        $agentCode = $auth_params[0];
        $str_timestamp = $auth_params[1];
        $nonce_string = $auth_params[2];
        $signature = $auth_params[3];

        if ($agentCode != env('HERA_AGENT_CODE')) {
            return false;
        }
        if (!$this->verifyNonceString($nonce_string)) {
            return false;
        }
        if (!$this->verifyTimestamp($str_timestamp)) {
            return false;
        }

        $callback_public_key = storage_path('/encrypt_keys/public_key_callback.pem');
        $input_text = sprintf('%s %s %s %s', $http_method, $api_path, $str_timestamp, $nonce_string);
        $signature = base64_decode($signature);
        if (openssl_verify($input_text, $signature, file_get_contents($callback_public_key), OPENSSL_ALGO_SHA256) !== 1) {
            return false;
        }

        return true;
    }

    /**
     * Verify nonce string
     *
     * @param string $nonce_string
     * @return boolean
     */
    protected function verifyNonceString(string $nonce_string): bool
    {
        return !is_null($nonce_string) && (strlen($nonce_string) > 0);
    }

    /**
     * Verify timestamp
     *
     * @param [type] $str_timestamp
     * @return boolean
     */
    protected function verifyTimestamp($str_timestamp): bool
    {
        try {
            $time = floatval($str_timestamp);
            $utc_now_timestamp = $this->getUtcNowTimestamp();
            $time_difference = abs($utc_now_timestamp - $time) / 1000;

            return abs($time_difference) <= env('HERA_AUTH_TIME_TOLERANCE');
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * Get utc timestamp
     *
     * @return int
     */
    public function getUtcNowTimestamp(): int
    {
        return (int) (new DateTime('now', new DateTimeZone('UTC')))->format('Uv');
    }
}
