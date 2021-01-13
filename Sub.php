<?php

include_once "database.php";
include_once "operations.php";

class Sub extends database implements operations{
  
    private $id;
    private $name;
    private $photo;
    private $categorie_id;


    //getters
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getPhoto()
    {
        return $this->photo;
    }
    public function getCategoryId()
    {
        return $this->categorie_id;
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
    public function setPhoto($photo)
    {
       $this->photo = $photo;
    }
    public function setCategoryId($categorie_id)
    {
       $this->categorie_id = $categorie_id;
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

    public function getSubByCat()
    {
        $query = "SELECT `sub_cate`.* FROM `sub_cate` WHERE `sub_cate`.`categorie_id` = $this->categorie_id";
        return $this->runDQL($query);
    }



    
}

?>