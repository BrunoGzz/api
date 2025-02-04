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

$query = stripcslashes($_GET["s"]);
$query = mysqli_real_escape_string($conn, $query);

$sql = "SELECT * FROM searches WHERE searchName='$query'";
$results = mysqli_query($conn, $sql);

$final_array = [];

if($results->num_rows){
    while($row = $results->fetch_assoc()){
        if($row["url"] != null && $row["url"] != "" && $row["url"] != "null"){
            if($_GET["q"] != null || $_GET["q"] != ""){
                array_push($final_array, $row["url"].urlencode($_GET["q"]));
            }else{
                array_push($final_array, $row["url_web"]);
            }
        }else{
            array_push($final_array, $row["url_web"]);
        }
    }
    echo stripslashes(json_encode($final_array, JSON_UNESCAPED_UNICODE));
}else{
    echo "";
}
