<?php
require_once __DIR__ . '/vendor/autoload.php';

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: content-type");
header("Access-Control-Allow-Methods: OPTIONS,GET,PUT,POST,DELETE");

use DonatelloZa\RakePlus\RakePlus;

if(!isset($_GET['q']) or !isset($_GET['c'])){
    echo "Error: Send all the info.";
}
else{
    $caracteres = array(
        'À'=>'A', 'Â'=>'A', 'Ä'=>'A', 'Á'=>'A', 'Ã'=>'A', 'Å'=>'A',
        'È'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'É'=>'E',
        'Ì'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Í'=>'I',
        'Ò'=>'O', 'Ô'=>'O', 'Ö'=>'O', 'Ó'=>'O', 'Õ'=>'O',
        'Ù'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ú'=>'U',
        'à'=>'a', 'â'=>'a', 'ä'=>'a', 'á'=>'a', 'ã'=>'a', 'å'=>'a',
        'è'=>'e', 'ê'=>'e', 'ë'=>'e', 'é'=>'e',
        'ì'=>'i', 'î'=>'i', 'ï'=>'i', 'í'=>'i',
        'ò'=>'o', 'ô'=>'o', 'ö'=>'o', 'ó'=>'o', 'õ'=>'o',
        'ù'=>'u', 'û'=>'u', 'ü'=>'u', 'ú'=>'u',
    );

    $word = $keywords = RakePlus::create(strtr(strtolower($_GET["q"]), $caracteres), 'es_AR')->sortByScore('desc')->scores();

    $url = "https://es.wikipedia.org/w/api.php?action=query&prop=extracts&exlimit=1&explaintext=1&format=json&formatversion=2&origin=*";

    $prev_url = "https://es.wikipedia.org/w/rest.php/v1/page/".str_replace(" ", "_", urlencode(key($word)))."/bare";

    $complexity = "&exsentences=".$_GET["c"]; 
    $title = "&titles=". str_replace(" ", "_", urlencode(key($word)));

    $ch = file_get_contents($prev_url);
    $response = json_decode($ch, true);

    if (isset($response["redirect_target"])) {
        $pattern = '/page\/(.*)\/bare/';
        if (preg_match($pattern, $response["redirect_target"], $matches)) {
            $page_name = $matches[1];
            $final_result = file_get_contents($url . "&titles=". $page_name . $complexity);
            echo $final_result;
        } else {
            echo "Error 404";
        }
    } else {
        if (isset($response->errorKey)) {
            $error_key = $response->errorKey;
            echo $error_key;
        } else {
            $final_result = file_get_contents($url . $title . $complexity);
            echo $final_result;
        }
    }
}
?>