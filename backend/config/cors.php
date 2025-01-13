<?php

return [


    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'], // Permite todos os métodos (GET, POST, PUT, DELETE, etc.).

    'allowed_origins' => ['http://localhost:5173'], // Substitua pelo domínio/URL do seu frontend.

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // Permite todos os cabeçalhos.

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true, // Habilita cookies compartilhados, útil se o frontend usar autenticação baseada em cookies.
];
