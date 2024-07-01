<?php
return [
    "errors" => [
        'api' => [
            'BadRequest' => 'Some request parameters are missing or invalid.',
            'Unauthorized' => 'Verification of the authorization header has failed.',
            'InsufficientAgentBalance' => 'The transaction has failed due to insufficient agent balance.',
            'InsufficientPlayerBalance' => 'The transaction has failed due to insufficient player balance.',
            'Forbidden' => 'Forbidden access.',
            'PlayerAlreadyExists' => 'A player with the specified code already exists.',
            'AlreadyProcessed' => 'The transaction with the specified id has already been processed.',
            'NotFound' => 'Some resources do not exist or are disabled.',
            'PlayerNotFound' => 'The player with the specified code does not exist.',
            'GameProviderNotFound' => 'The game provider with the specified code does not exist.',
            'GameNotFound' => 'The game with the specified code does not exist.',
            'ReferenceNotFound' => 'The resource with the specified reference does not exist.',
            'TooManyRequests' => 'The number of requests within a specific time window exceeded the configured limit.',
            'UnknownError' => 'An error occurred while processing the request.',
        ],
        'seamless_wallet' => [
            'Unauthorized' => 'Verification of the authorization header has failed.',
            'InsufficientPlayerBalance' => 'The transaction has failed due to insufficient player balance.',
            'AlreadyProcessed' => 'The transaction with the specified id has already been processed.',
            'NotFound' => 'Some resources do not exist or are disabled.',
        ]
    ],

    'api_urls' => [
        'integration_api' => [
            'agent_balance' => 'IntegrationAPI/AgentBalance',
            'game_provider' => 'IntegrationAPI/GameProviders',
            'games' => 'IntegrationAPI/Games',
            'launch_game' => 'IntegrationAPI/LaunchGame',
            'kick_player' => 'IntegrationAPI/KickPlayer'
        ],
        'wallet_callback' => [
            'balance' => 'Balance',
            'transaction' => 'Transaction'
        ],
        'data_feed_api' => [
            'transaction' => 'DataFeedAPI/Transaction',
            'transactions' => 'DataFeedAPI/Transactions',
            'open_game_history' => 'DataFeedAPI/OpenGameHistory',
            'game_round_details_by_id' => 'DataFeedAPI/GameRoundDetailsById',
            'game_round_details' => 'DataFeedAPI/GameRoundDetails',
            'game_history_details' => 'DataFeedAPI/GameHistoryDetails',
        ]
    ]
];
