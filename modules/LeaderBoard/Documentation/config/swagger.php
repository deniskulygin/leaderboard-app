<?php
declare(strict_types = 1);

return [
    'view' => 'index',
    'assets' => [
        'swagger_ui_bundle' => 'swagger-ui-bundle.js',
        'swagger_ui_css' => 'swagger-ui.css',
        'favicon_32' => 'favicon-32x32.png',
        'favicon_16' => 'favicon-16x16.png',
        'swagger_ui_standalone_preset' => 'swagger-ui-standalone-preset.js',
    ],
    'paths' => [
        'assets' => base_path('vendor/swagger-api/swagger-ui/dist'),
        'docs' => resource_path('documentation'),
        'docs_json' => 'swagger.json',
        'build_swagger_path' => base_path('public'),
        'build_swagger_file' => 'swagger.json',
    ],
];
