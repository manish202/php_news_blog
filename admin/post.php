<?php include "parts/header.php"; ?>
        <div class="row align-items-center">
            <div class="col-md-9"><h2 class="text-capitalize p-3">all posts</h2></div>
            <div class="col-md-3"><a href="add_post.php" class="btn btn-dark">add post</a></div>
        </div>
        <div class="row">
            <table class="table text-center table-hover text-capitalize">
                <thead>
                    <tr>
                        <th>s.no</th>
                        <th>image</th>
                        <th>title</th>
                        <th>description</th>
                        <th>date</th>
                        <th>category</th>
                        <th>author</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $owner = $_SESSION['id'];
                    if($_SESSION['role'] == 1){
                        $x = "";
                    }else{
                        $x = "WHERE pauthor = $owner";
                    }
                    $limit = 3;
                    $page = (!empty($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page']:1;
                    $offset = ($page - 1) * $limit;
                    $query = "SELECT * FROM posts p JOIN category c ON p.pcat = c.cid JOIN users u ON p.pauthor = u.uid $x ORDER BY pid DESC LIMIT $offset,$limit";
                    $result = mysqli_query($conn,$query);
                    if($err = mysqli_error($conn)){
                        die($err);
                    }else{
                        if(mysqli_num_rows($result) > 0){
                            while($rows = mysqli_fetch_assoc($result)){
                                $t = substr($rows['ptitle'],0,20);
                                $d = substr($rows['pdesc'],0,20);
                                echo "<tr>
                                <td>{$rows['pid']}</td>
                                <td><img src='../images/{$rows['pimage']}' class='rounded'></td>
                                <td>$t...</td>
                                <td>$d...</td>
                                <td>{$rows['date']}</td>
                                <td>{$rows['cname']}</td>
                                <td>{$rows['fname']} {$rows['lname']}</td>
                                <td><a href='edit_post.php?pid={$rows['pid']}' class='btn btn-success mx-2 text-capitalize'>edit</a><a href='delete_post.php?pid={$rows['pid']}&cid={$rows['pcat']}&img={$rows['pimage']}' class='btn btn-danger text-capitalize'>delete</a></td>
                            </tr>";
                            }
                        }else{
                            echo "<tr><td colspan='8'>no records found.</td></tr>";
                        }
                    }
                ?>
                </tbody>
            </table>
            <nav>
                <ul class="pagination justify-content-center">
                    <?php
                        $r = mysqli_query($conn,"SELECT COUNT(uid) as total FROM posts p JOIN category c ON p.pcat = c.cid JOIN users u ON p.pauthor = u.uid $x");
                        if($err = mysqli_error($conn)){die($err);}
                        if(mysqli_num_rows($r) > 0){
                            $res = mysqli_fetch_assoc($r);
                            $total = $res['total'];
                            $total_page = ceil($total / $limit);
                            if($page > 1){
                                echo "<li class='page-item'><a class='page-link' href='post.php?page=".($page - 1)."'>previous</a></li>";
                            }
                            for($i=1;$i <= $total_page;$i++){
                                $a = ($page == $i)? "bg-dark text-white":"";
                                echo "<li class='page-item'><a class='page-link $a' href='post.php?page=$i'>$i</a></li>";
                            }
                            if($page < $total_page){
                                echo "<li class='page-item'><a class='page-link' href='post.php?page=".($page + 1)."'>next</a></li>";
                            }
                        }else{
                            die("something is wrong");
                        }
                        mysqli_close($conn);
                    ?>
                </ul>
            </nav>
        </div>
    </div>
</body>
</html>