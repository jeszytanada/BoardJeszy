<?php

function is_session(){	
   
    if (isset($_SESSION['username'])){
        return true;
    }
}
