<?php

include_once "database.php";
include_once "operations.php";

class City extends database implements operations{
  
    private $id;
    private $name;
    private $latitude;
    private $longitude;


    //getters
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getLat()
    {
        return $this->latitude;
    }
    public function getLong()
    {
        return $this->longitude;
    }
    
    // setters
    public function setId($id)
    {
       $this->id = $id;
    }
    public function setName($name)
    {
       $this->name = $name;
    }
    public function setLat($latitude)
    {
       $this->latitude = $latitude;
    }
    public function setLong($longitude)
    {
       $this->longitude = $longitude;
    }
    

    // abstract methods to implement

    public function selectData(){
        $query = "SELECT `cities`.* FROM `cities`";
        return $this->runDQL($query);
    }
    public function insertData(){
       
    }
    public function updateData(){

    }
    public function deleteData(){

    }

    
}

?>