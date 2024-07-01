<?php

namespace App\Services\API;

class DataFeedService extends BaseAPIService
{
    private $config;

    public function __construct()
    {
        $this->config = config('hera_game.api_urls.data_feed_api');
        parent::__construct($this->getUtcNowTimestamp(), uniqid());
    }

    public function getTransaction($attributes)
    {
        if (!$attributes['uuid']) {
            return response()->json([], 200);
        }

        $response = $this->handleHeraApi('GET', $this->config['transaction'], ['uuid' => $attributes['uuid']]);

        return $response->json();
    }

    public function getTransactions()
    {
        $response = $this->handleHeraApi('GET', $this->config['transactions']);

        return $response->json();
    }

    public function openGameHistory($attributes)
    {
        $response = $this->handleHeraApi('POST', $this->config['open_game_history'], $attributes);

        return $response->json();
    }

    public function gameRoundDetailsById($attributes)
    {
        $response = $this->handleHeraApi('GET', $this->config['game_round_details_by_id'], $attributes);

        return $response->json();
    }

    public function gameRoundDetails($attributes)
    {
        $response = $this->handleHeraApi('GET', $this->config['game_round_details'], $attributes);

        return $response->json();
    }

    public function gameHistoryDetails($attributes)
    {
        $response = $this->handleHeraApi('POST', $this->config['game_history_details'], $attributes);

        return $response->json();
    }
}
