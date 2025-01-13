<?php

return [
    'paths' => ['api/*'], // Rutas donde CORS está habilitado
    'allowed_methods' => ['*'], // Métodos HTTP permitidos, usa '*' para todos
    'allowed_origins' => ['*'], // Orígenes permitidos
    'allowed_origins_patterns' => [], // Patrones para orígenes
    'allowed_headers' => ['*'], // Encabezados permitidos
    'exposed_headers' => [], // Encabezados expuestos
    'max_age' => 0, // Tiempo máximo para cacheo de preflight
    'supports_credentials' => false, // Si se permiten credenciales
];
