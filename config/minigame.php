<?php

return [
    'url' => [
        'surepowerball' => "https://www.surepowerball.com/ajax_last_data.php",
        'game365' => "http://game.tgame365.com/powerball/result/round",
        'ntry' => "https://ntry.com/data/json/games/powerball/result.json",
    ],
    'max_retry' => 20,
    'mode' => [
        'surepowerball' => ['one', 'two', 'three'],
    ]
];
