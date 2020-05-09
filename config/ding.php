<?php

return [
    'robot' => [
        'default' => 'think007',
        'think007' => [
            'access_token' => env('THINK007_TOKEN',''),
            'secret' => env('THINK007_SECRET','')
        ]
    ],
    'work-notice' => [
        'appkey' => env('DT_KEY'),
        'appsecret' => env('DT_SECRET'),
        'agent_id' => env('DT_AGENT_ID'),
    ],

    'http' => [
        'timeout' => env('DT_TIMEOUT',2),
    ],
];
