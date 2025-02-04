<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: content-type");
header("Access-Control-Allow-Methods: OPTIONS,GET,PUT,POST,DELETE");

$servername = "localhost";
$username = "u272808541_searchoutAdmin";
$password = "Donner2008.";
$dbname = "u272808541_searchout";

$conn = new mysqli($servername, $username, $password, $dbname);

$id = uniqid("", true);
$searchName = strtolower($_POST["searchName"]);
$url = strtolower($_POST["url"]);
$url_web = strtolower($_POST["url_web"]);
$stars = intval($_POST["stars"]);

if($_POST["password"] == "LqXs%ikk3YfJ*G!&!2T%FJVU8140!lt&6Ol5u%&e7!DNT1&rb"){
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }   
    $sql = "INSERT INTO searches (id, searchName, url, stars, url_web) VALUES ('$id', '$searchName', '$url', $stars, '$url_web')";
    if (mysqli_query($conn, $sql)) {
            echo "New record created successfully";
    } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}else{
    echo "Wrong password";
}

mysqli_close($conn);


