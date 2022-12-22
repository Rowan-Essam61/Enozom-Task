<?php

class Cities{

    private $table="city";
    private $conn;
    public $id;
    public $name;
    public $country_id;
    

    public function __construct($db){
        $this->conn=$db;
    }

    public function create(){
        $sql="INSERT INTO $this->table (name,country_id) value (?,?)";
        $stmt=$this->conn->prepare($sql);
        $stmt->bindParam(1,$this->name);
        $stmt->bindParam(2,$this->country_id);
        if( $stmt->execute())
            echo "added";
    }


}
?>