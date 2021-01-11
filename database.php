<?php

class database { 

    public $serverName = 'localhost'; // hostname
    public $username = 'root';
    public $password = '';
    public $dbName = 'nti_ecommerce';
    public $con;
    public function __construct()
    {
        $this->con = new mysqli($this->serverName,$this->username,$this->password,$this->dbName);
        if($this->con->connect_error){
            die("Connection failed: " . $this->con->connect_error);
            // echo $con->connect_error;
        }else{
            // echo "DB is connected";
        }
    }

    public function runDML($query)
    {
        // insert / update / delete
        $result = $this->con->query($query);
        if($result === TRUE){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function runDQL($query)
    {
        // selectes
        $result = $this->con->query($query);
        if($result->num_rows > 0){
            return $result;
        }else{
            return [];
        }
    }

}

