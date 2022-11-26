<?php
    session_start();
    if(!isset($_SESSION['name']) || !isset($_SESSION['id']) || !isset($_SESSION['role'])){
        header("Location: index.php");
    }else{
        include "config/config.php";
        if(empty($_GET['pid']) || !is_numeric($_GET['pid']) || empty($_GET['cid']) || !is_numeric($_GET['cid']) || empty($_GET['img'])){
            header("Location: post.php");
        }else{
            if($_SESSION['role'] == 1){$x = "";}else{$x = "&& pauthor = {$_SESSION['id']}";}
            $pid = mysqli_real_escape_string($conn,$_GET['pid']);
            $sql = "DELETE FROM posts WHERE pid = $pid $x;UPDATE category SET post_under_cat = post_under_cat - 1 WHERE cid = {$_GET['cid']};";
            $query = mysqli_multi_query($conn,$sql);
            if($err = mysqli_error($conn)){die($err);}
            if($query){
                rename("../images/{$_GET['img']}","../bkp/{$_GET['img']}");
                header("Location: post.php");
            }else{
                die("something is wrong.");
            }
        }
    }
?>