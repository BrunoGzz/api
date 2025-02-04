<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: content-type");
header("Access-Control-Allow-Methods: OPTIONS,GET,PUT,POST,DELETE");

$servername = "localhost";
$username = "u272808541_searchoutAdmin";
$password = "Donner2008.";
$dbname = "u272808541_searchout";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$query = stripcslashes($_GET["q"]);
$query = mysqli_real_escape_string($conn, $query);

$sql = "SELECT * FROM searches WHERE searchName LIKE '%$query%' LIMIT 10;";
$results = mysqli_query($conn, $sql);
$final_array = [];

if($results->num_rows){
    while($row = $results->fetch_assoc()){
        array_push($final_array, $row["searchName"]);
    }
    echo json_encode($final_array, JSON_UNESCAPED_UNICODE);
}else{
    echo "";
}
