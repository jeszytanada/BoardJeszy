<?php

function validate_between($check, $min, $max) 
{
    $n = mb_strlen($check);
    return $min <= $n && $n <= $max;
}

function redirect($url) 
{
    header("Location:$url");
}

function check_valid_email($email) 
{
    return preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email);
}

function check_username_format($username) 
{
     return !((preg_match('/[^a-zA-Z0-9_]\-/', $username)) || (preg_match('/_{2}/', $username)));
}
