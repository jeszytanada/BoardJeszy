<?php

function is_In_Session(){	
   
    if (isset($_SESSION['username'])){
        return true;
    }
}
