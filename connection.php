<?php 

    $localhost = "localhost";
    $username = "root";
    $password = "";
    $database = "crud_sweetalert";

    $con = new mysqli($localhost, $username, $password, $database);
    if($con->connect_error){
        die("Connection Failed:".$con->connect_error);
    }else{
        // echo "success";
    }

?>