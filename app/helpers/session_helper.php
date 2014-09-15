<?php

function is_logged() 
{
    if ($_SESSION['username']) {
       return true;
    } 
    return false;
    
}
