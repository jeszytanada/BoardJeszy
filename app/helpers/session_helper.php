<?php

function is_session() {	
    if ($_SESSION['username']) {
       return true;
    }
}
