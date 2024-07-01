<?php

namespace App\Services\API;

class MiniGameAPIService extends BaseAPIService
{
    private $config;
    public function __construct()
    {
        $this->config = config('minigame.url');
        parent::__construct($this->getUtcNowTimestamp(), uniqid());
    }

    public function getGameNtry()
    {
        $response = $this->handleCallApi('GET', $this->config['ntry']);

        return $response->json();
    }

    public function getGameSurepowerball()
    {
        $response = $this->handleCallApi('GET', $this->config['surepowerball'] . "?version=one");

        return $response->json();
    }

    public function getGame365()
    {
        $response = $this->handleCallApi('GET', $this->config['game365']);

        return $response->json();
    }
}
