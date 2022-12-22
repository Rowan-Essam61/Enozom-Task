<?php

class Database{
	private $host='localhost';
    private $db_name="id20051359_enozom_task";
    private $user='id20051359_root';
    private $password='Rowan_123456';
    private $conn;

    public function connect(){
        $this->conn=null;

        try{
            $this->conn=new PDO("mysql:host=$this->host;dbname=$this->db_name",
            $this->user,$this->password);
            $this->conn -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e){
            echo "Connection Failed:".$e->getMessage();
        }
        return $this->conn;
    }
}

	?>

