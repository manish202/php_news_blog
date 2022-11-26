<div class="col-md-3">
                <form class="row g-2 search-form" action="search.php" method="get" autocomplete="off">
                    <h3>search</h3>
                    <div class="col-auto">
                        <input type="text" name="q" class="form-control" placeholder="search">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary mb-3">search</button>
                    </div>
                </form>
                <div class="recent-posts mt-4 mb-5">
                    <h3>recent posts</h3>
                    <?php
                        $query2 = "SELECT * FROM posts p JOIN category c ON p.pcat = c.cid ORDER BY date DESC LIMIT 0,5";
                        $result3 = mysqli_query($conn,$query2) or die(mysqli_error($conn));
                        if(mysqli_num_rows($result3) > 0){
                            while($rows = mysqli_fetch_assoc($result3)){
                                $date = date_format(date_create($rows['date']),"d M Y");
                                $pid = "single.php?pid={$rows['pid']}";
                                $title = substr($rows['ptitle'],0,20);
                                echo "<div class='card mt-3 text-capitalize'>
                                <div class='row g-0'>
                                    <div class='col-md-4'>
                                        <a href='$pid'><img src='images/{$rows['pimage']}'></a>
                                    </div>
                                    <div class='col-md-8'>
                                        <div class='card-body'>
                                            <a href='$pid'>$title</a>
                                            <div class='py-1'>
                                                <a href='category.php?cid={$rows['cid']}&cname={$rows['cname']}' class='mx-1'><i class='fa-solid fa-tags'></i> {$rows['cname']}</a><span class='mx-1'><i class='fa-solid fa-calendar'></i> $date</span>
                                            </div>
                                        </div>
                                        <a href='$pid' class='btn btn-primary btn-sm float-end mx-4'>read more</a>
                                    </div>
                                </div>
                            </div>";
                            }
                        }else{
                            echo "<div class='alert alert-danger'>no recent posts found</div>";
                        }
                    ?>
                </div>
            </div>