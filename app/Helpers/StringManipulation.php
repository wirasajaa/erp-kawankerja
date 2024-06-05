<?php
if (!function_exists('systemMessage')) {
    function systemMessage($public_message, $system_message)
    {
        return config('app.env') == 'local' ? $system_message : $public_message;
    }
}
if (!function_exists('getNip')) {
    function getNip()
    {
        return "KKI" . date('dmyis', strtotime(now()));
    }
}
if (!function_exists('readDate')) {
    function readDate(string $str_date): string
    {
        return date('d F Y', strtotime($str_date));
    }
}
if (!function_exists('readTime')) {
    function readTime(string $str_date): string
    {
        return date('H:i', strtotime($str_date));
    }
}
