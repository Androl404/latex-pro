<?php

/**
 * Check if a string consists of a single repeated character using a regular expression.
 *
 * @param string $str The input string to check.
 * @return bool True if the string consists of a single repeated character, false otherwise.
 */
function isDummyLine(string $str)
{
    return preg_match('/^(.)\1*$/', $str) === 1;
}

/**
 * Check if the line contains the 'From file' string to verify from what file the following messages are.
 *
 * @param string $str The input string to verify.
 * @return bool True if the string is a file line, false otherwise.
 */
function isFileLine(string $str)
{
    return str_starts_with($str, "From file ");
}

/**
 * Check if the line is an important line, which means that is the first line of a error, warning or info from the compiler's log.
 *
 * @param string $str The input string to verify.
 * @return string Returns string with the type of message, or 'false' if it cannot determine it (the line is not important).
 */
function isImportantLine(string $str) {
    if (str_contains(strtolower($str), "warning")) {
        return 'warning';
    } elseif (str_starts_with($str, "!")) {
        return 'error';
    } elseif (preg_match('/\binfo\b[^\w]?/', strtolower($str)) || str_contains($str, "Overfull") || str_contains($str, "Underfull")) {
        return 'info';
    } else {
        return '';
    }
}

