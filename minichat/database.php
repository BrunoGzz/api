<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: content-type");
    header("Access-Control-Allow-Methods: OPTIONS,GET,PUT,POST,DELETE");

    $server = 'localhost';
    $username = 'u272808541_minichatAdmin';
    $password = 'Donner2008.';
    $database = 'u272808541_minichat';

    try{
        $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
    }catch(PDOException $e){
        die('Connection failed: '.$e->getMessage());
    }
?>