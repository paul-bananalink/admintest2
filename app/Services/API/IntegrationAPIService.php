<?php

namespace App\Services\API;

class IntegrationAPIService extends BaseAPIService
{
    private $config;
    public function __construct()
    {
        $this->config = config('hera_game.api_urls.integration_api');
        parent::__construct($this->getUtcNowTimestamp(), uniqid());
    }

    public function getBalance()
    {
        $response = $this->handleHeraApi('GET', $this->config['agent_balance']);

        return $response->json();
    }

    public function gameProviders()
    {
        $response = $this->handleHeraApi('GET', $this->config['game_provider']);

        return $response->json();
    }

    public function games($attributes)
    {
        $response = $this->handleHeraApi('GET', $this->config['games'], $attributes);

        return $response->json();
    }

    public function launchGame(array $attributes)
    {
        $response = $this->handleHeraApi('POST', $this->config['launch_game'], $attributes);

        return $response->json();
    }

    public function kickPlayer(array $attributes)
    {
        $response = $this->handleHeraApi('POST', $this->config['kick_player'], $attributes);

        return $response->json();
    }
}
