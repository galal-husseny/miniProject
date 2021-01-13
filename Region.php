<?php

include_once "database.php";
include_once "operations.php";

class Region extends database implements operations{
  
    private $id;
    private $name;
    private $latitude;
    private $longitude;
    private $citie_id;


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
    public function getCityId()
    {
        return $this->citie_id;
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
    public function setCityId($citie_id)
    {
       $this->citie_id = $citie_id;
    }
    

    // abstract methods to implement

    public function selectData(){
        
    }
    public function insertData(){
       
    }
    public function updateData(){

    }
    public function deleteData(){

    }

    public function getRegionsByCity()
    {
        $query = "SELECT `regions`.* FROM `regions` WHERE `regions`.`citie_id` = $this->citie_id ";
        return $this->runDQL($query);
    }

    
}

?>