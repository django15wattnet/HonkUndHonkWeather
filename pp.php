<?php

function pp(string $key): void 
{
    $lang = get_bloginfo('language');
    
    try {
        $transTab = require_once "resources/lang/{$lang}.php";
    } catch (Throwable $e) {
        error_log($e->getMessage());
        print($key);
        return;
    }
    
    if (true === isset($transTab[$key])) {
        print($transTab[$key]);
        return;
    }
    
    print($key);
}
