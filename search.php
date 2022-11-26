<?php include "parts/header.php"; ?>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-9">
            <h3 class='text-capitalize pb-2'>search for : <?php echo $_GET['q']; ?></h3>
                <?php
                    $limit = 5;
                    $page = (!empty($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page']:1;
                    $offset = ($page - 1) * $limit;
                    $query = "SELECT * FROM posts p JOIN category c ON p.pcat = c.cid JOIN users u ON p.pauthor = u.uid WHERE CONCAT(ptitle,pdesc) LIKE '%{$_GET['q']}%' ORDER BY pid DESC LIMIT $offset,$limit";
                    $result = mysqli_query($conn,$query);
                    if($err = mysqli_error($conn)){
                        die($err);
                    }else{
                        if(mysqli_num_rows($result) > 0){
                            while($rows = mysqli_fetch_assoc($result)){
                                echo card($rows);
                            }
                        }else{
                            echo "<div class='alert alert-danger'>no posts found</div";
                        }
                    }
                ?>
                <nav>
                    <ul class="pagination justify-content-center">
                        <?php
                            $r = mysqli_query($conn,"SELECT COUNT(uid) as total FROM posts p JOIN category c ON p.pcat = c.cid JOIN users u ON p.pauthor = u.uid WHERE CONCAT(ptitle,pdesc) LIKE '%{$_GET['q']}%'");
                            if($err = mysqli_error($conn)){die($err);}
                            if(mysqli_num_rows($r) > 0){
                                $res = mysqli_fetch_assoc($r);
                                $total = $res['total'];
                                $total_page = ceil($total / $limit);
                                if($page > 1){
                                    echo "<li class='page-item'><a class='page-link' href='search.php?q={$_GET['q']}&page=".($page - 1)."'>previous</a></li>";
                                }
                                for($i=1;$i <= $total_page;$i++){
                                    $a = ($page == $i)? "bg-dark text-white":"";
                                    echo "<li class='page-item'><a class='page-link $a' href='search.php?q={$_GET['q']}&page=$i'>$i</a></li>";
                                }
                                if($page < $total_page){
                                    echo "<li class='page-item'><a class='page-link' href='search.php?q={$_GET['q']}&page=".($page + 1)."'>next</a></li>";
                                }
                            }else{
                                die("something is wrong");
                            }
                        ?>
                    </ul>
                </nav>
            </div>
            <?php include "parts/sidebar.php"; ?>
        </div>
    </div>
<?php include "parts/footer.php"; ?>