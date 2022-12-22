<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/connect.php';
include_once '../Models/Countries.php';

$database=new Database();   
$db=$database->connect();


$countries=new Countries($db);

$result=$countries->read();


$num=$result->rowCount();

if($num>0){

$countries=array();
$countries_arr['data']=array();

    while($row=$result->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $country_item=array(
            'id'=>$id,
            'name'=>$name,
            'city'=>$city
        );

        array_push($countries_arr['data'],$country_item);

    }

    echo json_encode($countries_arr);

}
else{
    echo json_encode(
        array('message'=> "No Posts Yet")
    );
}



?>