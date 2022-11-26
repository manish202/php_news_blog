<?php 
    include "parts/header.php";
    if(!isset($_POST['update']) && (empty($_GET['uid']) || !is_numeric($_GET['uid']))){
        header("Location: user.php");
    }
    $uid = mysqli_real_escape_string($conn,$_GET['uid']);
    if(isset($_POST['update']) && !empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['uname']) && !empty($_POST['uid']) && isset($_POST['role'])){
        $fname = mysqli_real_escape_string($conn,$_POST['fname']);
        $lname = mysqli_real_escape_string($conn,$_POST['lname']);
        $uname = mysqli_real_escape_string($conn,$_POST['uname']);
        $role = mysqli_real_escape_string($conn,$_POST['role']);
        $uid = mysqli_real_escape_string($conn,$_POST['uid']);
        $sql = "UPDATE users SET fname = '$fname',lname = '$lname',uname = '$uname',role = $role WHERE uid = $uid";
        $ans = mysqli_query($conn,$sql);
        if($err = mysqli_error($conn)){die($err);}
        if($ans){
            header("Location: users.php");
        }else{
            echo "<div class='alert alert-danger'>fail!</div>";
        }
    }
    $result = mysqli_query($conn,"SELECT * FROM users WHERE uid = $uid");
    if($err = mysqli_error($conn)){
        die($err);
    }else{
        if(mysqli_num_rows($result) == 1){
            $rows = mysqli_fetch_assoc($result);
        }else{
            die("something is wrong.");
        }
    }
?>
        <h2 class="text-capitalize p-3">edit user</h2>
        <form autocomplete="off" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="w-50 m-auto bg-light p-3 text-capitalize" method="post">
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">first name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="fname" value="<?php echo $rows['fname']; ?>" required>
                    <input type="hidden" name="uid" value="<?php echo $rows['uid']; ?>">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">last name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="lname" value="<?php echo $rows['lname']; ?>" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">user name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="uname" value="<?php echo $rows['uname']; ?>" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">user role</label>
                <div class="col-sm-10">
                    <select class="form-select" name="role" required>
                        <?php
                            if($rows['role'] == 0){
                                echo "<option value='0' selected>normal user</option>  
                                <option value='1'>admin</option>";
                            }else{
                                echo "<option value='0'>normal user</option>  
                                <option value='1' selected>admin</option>";
                            }
                        ?>  
                    </select>
                </div>
            </div>
            <input type="submit" class="btn btn-dark d-block" value="update" name="update">
        </form>
    </div>
</body>
</html>