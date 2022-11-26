<?php 
    include "parts/header.php";

    if(isset($_POST['save']) && !empty($_POST['cname'])){
        $cname = mysqli_real_escape_string($conn,$_POST['cname']);
        $sql = "INSERT INTO category(cname) VALUES('$cname')";
        $ans = mysqli_query($conn,$sql);
        if($err = mysqli_error($conn)){die($err);}
        if($ans){
            header("Location: category.php");
        }else{
            echo "<div class='alert alert-danger'>fail!</div>";
        }
    }
?>
        <h2 class="text-capitalize p-3">add category</h2>
        <form autocomplete="off" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="w-50 m-auto bg-light p-3 text-capitalize" method="post">
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">category name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="cname" required>
                </div>
            </div>
            <input type="submit" class="btn btn-dark d-block" value="save" name="save">
        </form>
    </div>
</body>
</html>