<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Fonts
    |--------------------------------------------------------------------------
    |
    | "local" loads bundled TTF files from resources/fonts/editorial after
    | publishing the font assets. "google" pulls from Google Fonts CDN.
    |
    */
    'fonts' => [
        'mode' => 'local', // local | google
        'display' => 'Fraunces',
        'sans' => 'DM Sans',
        'mono' => 'JetBrains Mono',
    ],

    /*
    |--------------------------------------------------------------------------
    | Scrollbar
    |--------------------------------------------------------------------------
    */
    'scrollbar' => [
        'size' => 6,
        'accent' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Paper grain overlay opacity
    |--------------------------------------------------------------------------
    */
    'paper_grain_opacity' => 0.06,

    /*
    |--------------------------------------------------------------------------
    | Terminal login
    |--------------------------------------------------------------------------
    |
    | Opt-in via the plugin API (->terminalLogin()) rather than config to keep
    | per-panel granularity. This entry only controls the intro animation key.
    |
    */
    'login' => [
        'session_key' => 'editorial-login-intro-seen',
        'type_speed_ms' => 55,
        'pause_after_ms' => 320,
        'start_delay_ms' => 1500,

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
