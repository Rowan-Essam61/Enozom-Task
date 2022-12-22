<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/connect.php';
include_once '../Models/Populations.php';

$database=new Database();   
$db=$database->connect();


$population=new Population($db);

$result=$population->read();


$num=$result->rowCount();

if($num>0){

$populations=array();
$populations_arr['data']=array();

    while($row=$result->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $population_item=array(
            'id'=>$id,
            'country_name'=>$country_name,
            'city_name'=>$city_name,
            'year'=>$year,
            'sex'=>$sexes,
            'value'=>$value,
            'reliabilty'=>$reliability,
        );

        array_push($populations_arr['data'],$population_item);

    }

    echo json_encode($populations_arr);

}
else{
    echo json_encode(
        array('message'=> "No Posts Yet")
    );
}



?>