<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Security Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains security-related configuration options for the
    | application including rate limiting, input validation, and security headers.
    |
    */

    'rate_limiting' => [
        'enabled' => env('RATE_LIMITING_ENABLED', true),
        'default_attempts' => env('RATE_LIMIT_DEFAULT_ATTEMPTS', 60),
        'default_decay' => env('RATE_LIMIT_DEFAULT_DECAY', 1), // minutes
    ],

    'input_validation' => [
        'enabled' => env('INPUT_VALIDATION_ENABLED', true),
        'sanitize_html' => env('SANITIZE_HTML', true),
        'max_string_length' => env('MAX_STRING_LENGTH', 255),
        'allowed_html_tags' => [], // No HTML tags allowed by default
    ],

    'security_headers' => [
        'enabled' => env('SECURITY_HEADERS_ENABLED', true),
        'x_content_type_options' => 'nosniff',
        'x_frame_options' => 'DENY',
        'x_xss_protection' => '1; mode=block',
        'referrer_policy' => 'strict-origin-when-cross-origin',
        'permissions_policy' => 'geolocation=(), microphone=(), camera=()',
        'content_security_policy' => [
            'default-src' => "'self'",
            'script-src' => "'self' 'unsafe-inline' 'unsafe-eval'",
            'style-src' => "'self' 'unsafe-inline'",
            'img-src' => "'self' data: https:",
            'font-src' => "'self' data:",
            'connect-src' => "'self'",
            'frame-ancestors' => "'none'",
        ],
    ],

    'password_reset' => [
        'token_length' => 64,
        'expiration_minutes' => 60,
        'max_attempts_per_hour' => 3,
        'throttle_seconds' => 3600, // 1 hour
    ],

    'session_security' => [
        'regenerate_on_login' => true,
        'invalidate_other_sessions' => true,
        'session_timeout_minutes' => 120,
        'remember_me_days' => 30,
    ],

    'api_security' => [
        'require_https' => env('API_REQUIRE_HTTPS', true),
        'cors_enabled' => env('API_CORS_ENABLED', true),
        'cors_origins' => env('API_CORS_ORIGINS', '*'),
        'cors_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
        'cors_headers' => ['Content-Type', 'Authorization', 'X-Requested-With'],
    ],

    'logging' => [
        'security_events' => env('LOG_SECURITY_EVENTS', true),
        'failed_login_attempts' => env('LOG_FAILED_LOGINS', true),
        'suspicious_activity' => env('LOG_SUSPICIOUS_ACTIVITY', true),
    ],

    'encryption' => [
        'sensitive_data_fields' => [
            'password',
            'token',
            'secret',
            'key',
        ],
    ],
];
