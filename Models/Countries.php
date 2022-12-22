<?php

class Countries{

    private $table="countries";
    private $conn;
    public $id;
    public $name=" ";
    

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
        $sql="INSERT INTO $this->table (name) value (?)";
        $stmt=$this->conn->prepare($sql);
        $stmt->bindParam(1,$this->name);
        if( $stmt->execute())
            echo "added";
    }





}
?>