<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/connect.php';
include_once '../Models/Countries.php';
include_once '../Models/Populations.php';
include_once '../Models/Cities.php';


$database=new Database();   
$db=$database->connect();


$countries=new Countries($db);
$population=new Population($db);
$city=new Cities($db);


$url = "https://countriesnow.space/api/v0.1/countries/population/cities";
$json = file_get_contents($url);
$json_data = json_decode($json, true);
$data=$json_data["data"];

$countries_arr=array();
$cities_arr=array();

for($i=0;$i<=count($data);$i++){
    if (!in_array($data[$i]["country"], $countries_arr))
    {
    $countries->name=$data[$i]["country"];
    array_push($countries_arr,$data[$i]["country"]);
    if($countries->name==null){
        $countries->name="any country";
    }
    $countries->create();
    }
    
}

for($i=0;$i<=count($data);$i++){
    if (!in_array($data[$i]["city"], $cities_arr)){
        array_push($cities_arr,$data[$i]["city"]);
        $city->name=$data[$i]["city"];
        $k=array_search($data[$i]["country"],$countries_arr);
        $city->country_id=$k+1;
        $city->create();
    }
    if(count($data[$i]["populationCounts"])>0){
    for($j=0;$j<count($data[$i]["populationCounts"]);$j++){
            $population->year=$data[$i]["populationCounts"][$j]["year"];
            $population->value=$data[$i]["populationCounts"][$j]["value"];
            $population->sexes=$data[$i]["populationCounts"][$j]["sex"];
            $population->reliability=$data[$i]["populationCounts"][$j]["reliabilty"];
            $k=array_search($data[$i]["country"],$countries_arr);
            $population->country_id=$k+1;
            $f=array_search($data[$i]["city"],$cities_arr);
            $population->city_id=$f+1;
            $population->create();
    }
    
    }

}

?>