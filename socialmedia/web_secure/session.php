<?php
session_set_cookie_params([
    'lifetime' => 60 * 60 * 24 * 10,
    'path' => '/',
    'domain' => 'snapters.com',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'none',
]);
session_start();
session_regenerate_id();
