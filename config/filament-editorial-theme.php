<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Terminal login
    |--------------------------------------------------------------------------
    |
    | Opt-in via the plugin API (->terminalLogin()) rather than config to keep
    | per-panel granularity. This entry only holds the optional background preview.
    |
    */
    'login' => [
        /*
        | Optional Blade view that renders behind the terminal as a blurred
        | preview. When the view exists, its <body> content is extracted and
        | injected into the login-preview-bg div. Leave null for a plain
        | dark backdrop (paper grain + kenburns animation only).
        */
        'preview_view' => null,
        'preview_data' => [],
    ],
];
