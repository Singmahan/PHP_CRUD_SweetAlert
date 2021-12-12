<?php 
    include_once 'connection.php';

    $id = $_POST['user_id'];
    $first_name = $_POST['edit_first_name'];
    $last_name = $_POST['edit_last_name'];
    $gender = $_POST['edit_gender'];
    $phone = $_POST['edit_phone'];

    $sql = "UPDATE user_info SET `first_name` = '$first_name',`last_name` = '$last_name',`gender` = '$gender',`phone` = '$phone' WHERE id = '$id'";
    $query = $con->query($sql) or die($con->error);
    
?>