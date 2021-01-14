<?php

include_once "database.php";
include_once "operations.php";

class Product extends database implements operations{
  
    private $id;
    private $name;
    private $photo;
    private $price;
    private $details;
    private $supplier_id;
    private $sub_category_id;
    private $brand_id;


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
    public function getSubCategoryId()
    {
        return $this->sub_category_id;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function getDetails()
    {
        return $this->details;
    }
    public function getSupplierId()
    {
        return $this->supplier_id;
    }
    public function getBrandId()
    {
        return $this->brand_id;
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
    public function setSubCategoryId($sub_category_id)
    {
       $this->sub_category_id = $sub_category_id;
    }

    public function setBrandId($brand_id)
    {
       $this->brand_id = $brand_id;
    }
    public function setSupplierId($supplier_id)
    {
       $this->supplier_id = $supplier_id;
    }
    public function setDetails($details)
    {
       $this->details = $details;
    }
    public function setPrice($price)
    {
       $this->price = $price;
    }


    

    // abstract methods to implement

    public function selectData(){
       $query = "SELECT `products`.* FROM `products` LIMIT 10";
       return $this->runDQL($query);

    }
    public function insertData(){
       
    }
    public function updateData(){

    }
    public function deleteData(){

    }

    public function getProductsBySub()
    {
       $query = "SELECT `products`.* FROM `products` WHERE `products`.`sub_category_id` = $this->sub_category_id";
       return $this->runDQL($query);
    }

    public function getSingleProduct()
    {
      $query = "SELECT `product_rating`.* FROM `product_rating` WHERE `product_rating`.`id` = $this->id";
      return $this->runDQL($query);

    }

    public function getReviewsByProduct()
    {
      $query = "SELECT `users_reviews`.* FROM `users_reviews` WHERE `users_reviews`.`product_id` = $this->id ";
      return $this->runDQL($query);
    }



    
}

?>