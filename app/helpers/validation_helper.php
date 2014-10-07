<?php
/**
 * Validate the minimum & max length
 * @param value to check, minimum & max length
 */
function validate_between($check, $min, $max) 
{
    $n = mb_strlen($check);
    return $min <= $n && $n <= $max;
}

/**
 * Redirect pages
 * @param $url of the page 
 */
function redirect($url) 
{
    header("Location:$url");
}

/**
 * validation for email, match regex
 * @param $email input 
 */
function is_valid_email($email) 
{
    return preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email);
}

/**
 * Username format
 * alphanumeric chars and underscore
 * @param $username 
 */
function is_valid_username($username) 
{
    return !((preg_match('/[^a-zA-Z0-9_]/', $username)) || (preg_match('/_{2}/', $username)));
}

/**
 * Name format
 * alphabetic characters only
 * @param $name input 
 */
function is_valid_name($name)
{
    if (ctype_alpha($name)) {
        return true;
    }
    return false;
}

/**
 * Whitespace format 
 * @param $text = for body & title 
 */
function is_valid_space($text)
{
    if ((preg_match('/[^\s]/', $text)) && (preg_match('/[\w]*/', $text))) {
        return true;
    }
    return false;
}
