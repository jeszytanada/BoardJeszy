<?php

function is_logged() 
{
    if ($_SESSION['username']) {
       return true;
    } else {
        return false;
    }
}
