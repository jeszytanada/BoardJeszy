<?php

function entities($string) 
{
    if (!$string) return;
    echo htmlspecialchars($string, ENT_QUOTES);
}
function readable_text($s) 
{
    $s = htmlspecialchars($s, ENT_QUOTES);
    $s = nl2br($s);
    return $s;
}

function notify($text, $notify_type = NULL) 
{
    if ($notify_type === 'error') {   
        return $reply = "<center><font size=4 face=Arial color=red>" . $text . "</font></center>";
    }
    return $reply = "<center> <font size=4 face=Arial color=blue>" . $text . "</font></center>";
}

function is_logged() 
{
    if ($_SESSION['id']) {
       return true;
    } 
    return false;
    
}