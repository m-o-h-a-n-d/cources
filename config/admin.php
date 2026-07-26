<?php

return [
    'email' => env('ADMIN_EMAIL', 'admin@example.com'),
    'password' => password_hash(env('ADMIN_PASSWORD', '123456'), PASSWORD_DEFAULT),
];