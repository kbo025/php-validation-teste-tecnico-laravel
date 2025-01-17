<?php

/**
 * Copyright (c) 2017 - present
 * LaravelGoogleRecaptcha - recaptcha.php
 * author: Roberto Belotti - roby.belotti@gmail.com
 * web : robertobelotti.com, github.com/biscolab
 * Initial version created on: 12/9/2018
 * MIT license: https://github.com/biscolab/laravel-recaptcha/blob/master/LICENSE
 */

/**
 * To configure correctly please visit https://developers.google.com/recaptcha/docs/start
 */
return [
    'api_site_key'                 => env('RECAPTCHA_SITE_KEY', ''),
    'api_secret_key'               => env('RECAPTCHA_SECRET_KEY', ''),
    'version'                      => 'v2',
    'curl_timeout'                 => 10,
    'skip_ip'                      => env('RECAPTCHA_SKIP_IP', []),
    'default_validation_route'     => 'biscolab-recaptcha/validate',
    'default_token_parameter_name' => 'token',
    'default_language'             => null,
    'default_form_id'              => 'biscolab-recaptcha-invisible-form',
    'explicit'                     => false,
    'api_domain'                   => 'www.google.com',
    'empty_message' => false,
    'error_message_key' => 'validation.recaptcha',
    'tag_attributes'               => [
        'theme'            => 'light',
        'size'             => 'normal',
        'tabindex'         => 0,
        'callback'         => null,
        'expired-callback' => null,
        'error-callback'   => null,
    ]
];
