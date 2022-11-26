<?php
    session_start();
    if(isset($_SESSION['name']) && isset($_SESSION['id']) && isset($_SESSION['role'])){
        header("Location: post.php");
    }
    include "config/config.php";
    $alert = "";
    if(!empty($_POST['uname']) && !empty($_POST['pword'])){
        $uname = mysqli_real_escape_string($conn,$_POST['uname']);
        $pword = mysqli_real_escape_string($conn,$_POST['pword']);
        $pword = md5($pword);
        $sql = "SELECT * FROM users WHERE uname = '$uname' && pword = '$pword'";
        $res = mysqli_query($conn,$sql);
        if($err = mysqli_error($conn)){die($err);}
        if(mysqli_num_rows($res) == 1){
            $data = mysqli_fetch_assoc($res);
            $_SESSION['name'] = $data['fname']." ". $data['lname'];
            $_SESSION['id'] = $data['uid'];
            $_SESSION['role'] = $data['role'];
            header("Location: post.php");
        }else{
            $alert = "<div class='alert alert-danger'>username or password is wrong. </div>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page....</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css_js/color.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6 logo text-center"><h1><a href="index.php">news blog</a></h1></div>
        </div>
        <div class="row justify-content-center">
            <div class="col-6 text-center">
                <h2 class="text-capitalize p-3">Login form</h2>
            </div>
        </div>
        <div class="row">
            <form autocomplete="off" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="w-50 m-auto bg-light p-3 text-capitalize" method="post">
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">username</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="uname" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="pword" required>
                    </div>
                </div>
                <input type="submit" class="btn btn-dark d-block" value="login" name="login">
            </form>
        </div>
        <div class="row justify-content-center">
            <div class="col-6 text-center"><?php echo $alert; ?></div>
        </div>
    </div>
</body>
</html>