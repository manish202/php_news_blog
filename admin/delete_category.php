<?php
    session_start();
    if(!isset($_SESSION['name']) || !isset($_SESSION['id']) || !isset($_SESSION['role']) || $_SESSION['role'] != 1){
        header("Location: index.php");
    }else{
        include "config/config.php";
        if(empty($_GET['cid']) || !isset($_GET['puc']) || !is_numeric($_GET['puc']) || !is_numeric($_GET['cid'])){
            header("Location: category.php");
        }else{
            $cid = mysqli_real_escape_string($conn,$_GET['cid']);
            $puc = mysqli_real_escape_string($conn,$_GET['puc']);
            if($puc == 0){
                $query = mysqli_query($conn,"DELETE FROM category WHERE cid = $cid");
                if($err = mysqli_error($conn)){die($err);}
                if($query){
                    header("Location: category.php");
                }else{
                    die("something is wrong.");
                }
            }else{
                die("you cant delete this category because it has". $puc. "post available.");
            }
        }
    }
?>