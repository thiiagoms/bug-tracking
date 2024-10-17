<?php

return [
    'pdo' => [
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'db_name' => 'bug_app',
        'db_username' => 'root',
        'db_user_password' => '',
        'default_fetch' => PDO::FETCH_OBJ
    ],
    'mysqli' => [
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'db_name' => 'bug_app',
        'db_username' => 'root',
        'db_user_password' => '',
        'default_fetch' => MYSQLI_ASSOC
    ]
];
