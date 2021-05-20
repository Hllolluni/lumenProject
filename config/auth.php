<?php

    return[
        'defaults' => [
            'guard' => 'user',
        ],

        'guards' => [
            "user"=>[
                "driver"=>"jwt",
                "provider"=>"user"
            ],
            "admin"=>[
                "driver"=>"jwt",
                "provider"=>"admin"
            ]
        ],

        'providers'=>[
            "user"=>[
                "driver"=>"eloquent",
                "model"=>App\Models\User::class,
            ],
            "admin"=>[
                "driver"=>"eloquent",
                "model"=>App\Models\Admin::class,
            ]
        ]

    ];
