<?php

class Population{

    private $table="population";
    private $conn;
    public $id;
    public $year;
    public $value;
    public $sexes;
    public $reliability;
    public $country_id;
    public $city_id;

    public function __construct($db){
        $this->conn=$db;
    }

    public function read(){
        $sql="SELECT * FROM $this->table  ";
        $stmt=$this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function create(){
        $sql="INSERT INTO $this->table (year,value,sexes,reliability,country_id,city_id) 
        value (?,?,?,?,?,?)";
        $stmt=$this->conn->prepare($sql);
        $stmt->bindParam(1,$this->year);
        $stmt->bindParam(2,$this->value);
        $stmt->bindParam(3,$this->sexes);
        $stmt->bindParam(4,$this->reliability);
        $stmt->bindParam(5,$this->country_id);
        $stmt->bindParam(6,$this->city_id);
        if( $stmt->execute())
            echo "added";
    }



}
?>