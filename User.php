<?php

include_once "database.php";
include_once "operations.php";

class User extends database implements operations{
  
    private $id;
    private $name;
    private $phone;
    private $email;
    private $pass;
    private $photo;
    private $gender;
    private $code;
    private $status;

    //getters
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getPhone()
    {
        return $this->phone;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getPass()
    {
        return $this->pass;
    }
    public function getPhoto()
    {
        return $this->photo;
    }
    public function getGender()
    {
        return $this->gender;
    }
    public function getCode()
    {
        return $this->code;
    }
    public function getStatus()
    {
        return $this->status;
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
    public function setPhone($phone)
    {
       $this->phone = $phone;
    }
    public function setEmail($email)
    {
       $this->email = $email;
    }
    public function setPass($password)
    {
        
       $this->pass = sha1($password);
    }
    public function setPhoto($photo)
    {
       $this->photo = $photo;
    }
    public function setCode($code)
    {
       $this->code = $code;
    }
    public function setStatus($status)
    {
       $this->status = $status;
    }
    public function setGender($gender)
    {
       $this->gender = $gender;
    }

    // abstract methods to implement

    public function selectData(){

    }
    public function insertData(){
        $query = "INSERT INTO `users` (`users`.`name`,`users`.`phone`,`users`.`email`,`users`.`password`,`users`.`gender`,`users`.`code`) 
        VALUES ('$this->name','$this->phone','$this->email','$this->pass','$this->gender','$this->code')";
        // echo $query;
        return $this->runDML($query);
    }
    public function updateData(){

    }
    public function deleteData(){

    }

    public function checkCode()
    {
        $query = "SELECT `users`.* FROM `users` WHERE `users`.`code` = '$this->code' AND `users`.`email` = '$this->email' ";
        return $this->runDQL($query);
    }

    public function updateStatus()
    {
        $query = "UPDATE `users` SET `users`.`status` = $this->status WHERE `users`.`email` = '$this->email'";
        return $this->runDML($query);
    }
    public function login()
    {
       $query = "SELECT `users`.* FROM `users` WHERE `users`.`email` = '$this->email' AND `users`.`password` = '$this->pass'";
       return $this->runDQL($query);

    }

    public function updateProfileInfo()
    {
        $query = "UPDATE `users` 
        SET `users`.`name` = '$this->name' ,
        `users`.`gender` = '$this->gender' ,
        `users`.`phone` = '$this->phone'";
            if($this->photo){
                $query .= " , `users`.`photo` = '$this->photo' ";
            }
         $query .= "WHERE `users`.`id` = '$this->id' ";
        return $this->runDML($query);
    }

    public function updateEmail()
    {
       $query = "UPDATE `users` 
       SET `users`.`email` = '$this->email' ,
        `users`.`status` = '$this->status' ,
        `users`.`code` = '$this->code' 
        WHERE `users`.`id` = $this->id ";
        return $this->runDML($query);
    }

    public function updatePassword()
    {
       $query = "UPDATE `users`
       SET `users`.`password` = '$this->pass' WHERE `users`.`id` = $this->id";
        return $this->runDML($query);

    }

    public function checkEmail()
    {
        $query = "SELECT `users`.* FROM `users`  WHERE `users`.`email` = '$this->email'";
        return $this->runDQL($query);
    }

    public function updateCode()
    {
       $query = "UPDATE `users` SET `users`.`code` = '$this->code' WHERE `users`.`email` = '$this->email' ";
       return $this->runDML($query);
    }

    public function getUserByEmail()
    {
        $query = "SELECT `users`.* FROM `users` WHERE `users`.`email` = '$this->email' ";
        return $this->runDQL($query);
    }
}

?>