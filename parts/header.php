<?php
    include "admin/config/config.php";
    $cur_page = pathinfo($_SERVER['PHP_SELF'],PATHINFO_FILENAME);
    $seo_title = "";$seo_desc = "";
    switch($cur_page){
        case "single":
            if(empty($_GET['pid']) || !is_numeric($_GET['pid'])){header("Location: index.php");}
            $query = "SELECT * FROM posts p JOIN category c ON p.pcat = c.cid JOIN users u ON p.pauthor = u.uid WHERE pid = {$_GET['pid']}";
            $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
            if(mysqli_num_rows($result) == 1){
                $rows = mysqli_fetch_assoc($result);
                $seo_title = $rows['ptitle'];
                $seo_desc = $rows['pdesc'];
            }else{header("Location: index.php");}
        break;
        case "search":
            if(empty($_GET['q'])){header("Location: index.php");}
            $seo_title = "showing result for {$_GET['q']}.";
            $seo_desc = "read blogs about {$_GET['q']}.";
        break;
        case "category":
            if(empty($_GET['cid']) || empty($_GET['cname']) || !is_numeric($_GET['cid'])){header("Location: index.php");}
            $seo_title = "showing result for {$_GET['cname']}.";
            $seo_desc = "read blogs about {$_GET['cname']}.";
        break;
        case "author":
            if(empty($_GET['uid']) || empty($_GET['author']) || !is_numeric($_GET['uid'])){header("Location: index.php");}
            $seo_title = "post written by {$_GET['author']}.";
            $seo_desc = "read blogs which is written by {$_GET['author']}.";
        break;
        default:
            $seo_title = "welcome to news blog website.";
            $seo_desc = "hey! here you can read amazing blogs related to sports,music,dance etc...";
    }
    function card($rows){
        $date = date_format(date_create($rows['date']),"d M Y");
        $pid = "single.php?pid={$rows['pid']}";
        $title = substr($rows['ptitle'],0,50);
        $desc = substr($rows['pdesc'],0,100);
        return "<div class='card mb-3 text-capitalize'>
        <div class='row g-0'>
            <div class='col-md-4'>
                <a href='$pid'><img src='images/{$rows['pimage']}' class='img-fluid p-3 fit'></a>
            </div>
            <div class='col-md-8'>
                <div class='card-body'>
                    <h5 class='card-title'><a href='$pid'>$title</a></h5>
                    <div class='py-2'>
                        <a href='category.php?cid={$rows['cid']}&cname={$rows['cname']}' class='mx-1'><i class='fa-solid fa-tags'></i> {$rows['cname']}</a><a href='author.php?uid={$rows['pauthor']}&author={$rows['fname']}' class='mx-1'><i class='fa-solid fa-user'></i> {$rows['fname']}</a><span class='mx-1'><i class='fa-solid fa-calendar'></i> $date</span>
                    </div>
                    <p class='card-text'>$desc...</p>
                </div>
                <a href='$pid' class='btn btn-primary float-end mx-4'>read more</a>
            </div>
        </div>
    </div>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $seo_title; ?></title>
    <meta name="description" content="<?php echo $seo_desc; ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css_js/color.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row logo">
            <div class="col-md-4 m-auto text-center"><h1><a href="index.php">news blog</a></h1></div>
        </div>
        <div class="row">
            <nav class="navbar navbar-dark bg-dark navbar-expand-sm">
                <div class="container-fluid">
                    <ul class="navbar-nav text-uppercase m-auto">
                        <?php
                            $result2 = mysqli_query($conn,"SELECT * FROM category WHERE post_under_cat > 0 ORDER BY cid DESC LIMIT 0,12");
                            if($err = mysqli_error($conn)){
                                die($err);
                            }else{
                                if(mysqli_num_rows($result2) > 0){
                                    while($rows2 = mysqli_fetch_assoc($result2)){
                                        $active = (isset($_GET['cid']) && $_GET['cid'] == $rows2['cid'])? "active":"";
                                        echo "<li class='nav-item'><a class='nav-link $active' href='category.php?cid={$rows2['cid']}&cname={$rows2['cname']}'>{$rows2['cname']}</a></li>";
                                    }
                                }else{
                                    echo "<li class='nav-item'><a class='nav-link' href=''>no category</a></li>";
                                }
                            }
                        ?>
                    </ul>
                </div>
            </nav>
        </div>
    </div>