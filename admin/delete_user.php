<?php
    session_start();
    if(!isset($_SESSION['name']) || !isset($_SESSION['id']) || !isset($_SESSION['role']) || $_SESSION['role'] != 1){
        header("Location: index.php");
    }else{
        include "config/config.php";
        if(empty($_GET['uid']) || !is_numeric($_GET['uid'])){
            header("Location: users.php");
        }else{
            $uid = mysqli_real_escape_string($conn,$_GET['uid']);
            $query = mysqli_query($conn,"DELETE FROM users WHERE uid = $uid");
            if($err = mysqli_error($conn)){die($err);}
            if($query){
                header("Location: users.php");
            }else{
                die("something is wrong.");
            }
        }
    }
?>