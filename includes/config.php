<?php
    ob_start(); // turns on output buffering ie wait until all php is executed before outputing
    session_start();

    date_default_timezone_set("Asia/Kolkata");

    try{
        $conn = new PDO("mysql:dbname=videoflix;host=localhost", "root","");
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
    
    }catch(PDOException $e){
        exit("Connection failed:".$e->getMessage());
    }
?>