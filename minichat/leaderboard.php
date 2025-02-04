<?php
    //Require database connection script
    require 'database.php';
    
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData);

    $resultTableHTML =  '<strong class="lh-1">THANKS FOR YOUR PARTICIPATION :). A NEW MINICHAT UPDATE WILL COME SOON! HAVE YOU EVER WONDERED WHAT GROUP CHATS ON MINICHAT COULD BE LIKE?</strong>';
    echo $resultTableHTML;
    //END OF PHP
    //END OF PHP
?>
