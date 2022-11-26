<?php
    session_start();
    if(!isset($_SESSION['name']) || !isset($_SESSION['id']) || !isset($_SESSION['role'])){
        header("Location: index.php");
    }
    $cur_page = pathinfo($_SERVER['PHP_SELF'],PATHINFO_FILENAME);
    $admin_pages = ["users","edit_user","delete_user","add_user","delete_category","category","edit_category","add_category"];
    if(in_array($cur_page,$admin_pages) && $_SESSION['role'] == 0){
        header("Location: post.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>blog control date 19/06/2022</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css_js/color.css">
</head>
<body>
    <div class="container">
        <div class="row align-items-center logo">
            <div class="col-md-4"><h1><a href="index.php">news blog</a></h1></div>
            <div class="col-md-5"><h5><?php echo "Hii ". $_SESSION['name']; ?></h5></div>
            <div class="col-md-3"><h5><a href='logout.php'>logout</a></h5></div>
        </div>
        <div class="row">
        <nav class="navbar navbar-dark bg-dark navbar-expand-sm">
            <div class="container-fluid">
                <ul class="navbar-nav">
                <?php
                    $bname = basename($_SERVER['PHP_SELF']);
                    if($_SESSION['role'] == 1){
                        $arr = [
                            "post.php" => "post",
                            "category.php" => "category",
                            "users.php" => "users"
                        ];
                    }else{
                        $arr = [
                            "post.php" => "post"
                        ];
                    }
                    foreach($arr as $key => $val){
                        $active = ($bname == $key) ? "active" : "";
                        echo "<li class='nav-item text-uppercase'>
                        <a class='nav-link $active' href='$key'>$val</a>
                    </li>";
                    }
                    include "config/config.php";
                ?>
                </ul>
            </div>
        </nav>
        </div>