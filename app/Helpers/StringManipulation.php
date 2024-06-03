<?php
if (!function_exists('systemMessage')) {
    function systemMessage($public_message, $system_message)
    {
        return config('app.env') == 'local' ? $system_message : $public_message;
    }
}
