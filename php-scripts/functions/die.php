<?php

function show_errors_and_die(array $array, string $to_redirect, string $message)
{
    if (count($array) == 0) {
        return True;
    } else {
        $head = "Location: " . $to_redirect . "?";
        foreach ($array as $error) {
            $head .= ($error . "=1&");
        }
        error_log($head . $message . "=1");
        header($head . $message . "=1");
        exit();
    }
}

function sendResponseCodeAndDie(int $http_response_code, string $message = "")
{
    http_response_code($http_response_code);
    if ($message)
        echo $message;
    exit();
}
