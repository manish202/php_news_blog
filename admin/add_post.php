<?php 
    include "parts/header.php";
    $alert = "";
    function valid_image(){
        global $alert;
        $name = $_FILES['img']['name'];
        $size = $_FILES['img']['size'];
        $tmp_name = $_FILES['img']['tmp_name'];
        $valid_ext = ["jpg","jpeg","png"];
        $ext = pathinfo($name,PATHINFO_EXTENSION);
        if(in_array($ext,$valid_ext)){
            if($size > 2097152){
                $alert = "<div class='alert alert-danger'>image size more then 2mb is invalid. </div>";
            }else{
                if(move_uploaded_file($tmp_name,"../images/$name")){
                    return true;
                }else{
                    $alert = "<div class='alert alert-danger'>image uploading failed. </div>";
                }
            }
        }else{
            $alert = "<div class='alert alert-danger'>image is invalid. only (jpg,jpeg,png) supported. </div>";
        }
    }
    if(isset($_POST['save']) && !empty($_POST['title']) && !empty($_POST['desc']) && !empty($_POST['category']) && !empty($_FILES['img']['name'])){
        $title = mysqli_real_escape_string($conn,$_POST['title']);
        $desc = mysqli_real_escape_string($conn,$_POST['desc']);
        $category = mysqli_real_escape_string($conn,$_POST['category']);
        $date = date("Y-m-d");
        $name = $_FILES['img']['name'];
        $author = $_SESSION['id'];
        if(valid_image()){
            $sql = "INSERT INTO posts(ptitle,pdesc,date,pimage,pcat,pauthor) VALUES('$title','$desc','$date','$name',$category,$author);UPDATE category SET post_under_cat = post_under_cat + 1 WHERE cid = $category;";
            $ans = mysqli_multi_query($conn,$sql);
            if($err = mysqli_error($conn)){die($err);}
            if($ans){
                header("Location: post.php");
            }else{
                $alert = "<div class='alert alert-danger'>image uploaded but data not inserted. </div>";
            }
        }
    }
?>
        <h2 class="text-capitalize p-3">add post</h2>
        <div class="row justify-content-center">
            <div class="col-6 text-center"><?php echo $alert; ?></div>
        </div>
        <form autocomplete="off" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="w-50 m-auto bg-light p-3 text-capitalize" method="post" enctype="multipart/form-data">
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">title</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="title" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">description</label>
                <div class="col-sm-10">
                    <textarea name="desc" class="form-control" cols="30" rows="10" required></textarea>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">thumbnail</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" name="img" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">category</label>
                <div class="col-sm-10">
                    <select class="form-select" name="category" required>
                          <?php
                            $query = mysqli_query($conn,"SELECT * FROM category");
                            if($err = mysqli_error($conn)){die($err);}
                            if(mysqli_num_rows($query) > 0){
                                echo "<option selected disabled>select category.</option>";
                                while($row = mysqli_fetch_assoc($query)){
                                    echo "<option value='{$row['cid']}'>{$row['cname']}</option>";
                                }
                            }else{
                                echo "<option selected disabled>no category found.</option>";
                            }
                          ?> 
                    </select>
                </div>
            </div>
            <input type="submit" class="btn btn-dark d-block" value="save" name="save">
        </form>
    </div>
</body>
</html>