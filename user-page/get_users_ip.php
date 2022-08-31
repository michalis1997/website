<?php
    
    $host_addr= gethostname(); 

    echo  gethostbyname($host_addr);
    echo   "   localhost IPv6 address: ";
    echo       $_SERVER['SERVER_ADDR']; 
     
    
     
?>