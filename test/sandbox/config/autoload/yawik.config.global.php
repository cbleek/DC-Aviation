<?php

return [
    'doctrine' =>[
        'connection' =>[
            'odm_default' =>[
                'connectionString' => 'mongodb://mongo1.hq.cross:27017/aviation',
            ]
        ],
        'configuration' => [
            'odm_default' => [
                'default_db'    => 'aviation',
            ]
        ],
    ],
    "core_options" => [
        'system_message_email' => "bleek@cross-solution.de",
    ]
];
