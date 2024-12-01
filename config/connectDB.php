<?php 
/**
 * Create a mysql connection
 */

 function connect(){
    try{
        $connection = new PDO("mysql:host=localhost;dbname=devofs","root","");
        return $connection;
    }catch(PDOException  $error){
        echo $error->getMessage();
    }
 }