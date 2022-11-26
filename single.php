<?php include "parts/header.php"; ?>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-9 text-primary text-capitalize">
                <?php
                    $date = date_format(date_create($rows['date']),"d M Y");
                ?>
                <h2><?php echo $rows['ptitle']; ?></h2>
                <div class='py-2'>
                    <a href='category.php?<?php echo "cid=". $rows['cid']. "&cname=" . $rows['cname']; ?>' class='mx-1'><i class='fa-solid fa-tags'></i> <?php echo $rows['cname']; ?></a><a href='author.php?<?php echo "uid=". $rows['pauthor'] . "&author=".$rows['fname']; ?>' class='mx-1'><i class='fa-solid fa-user'></i> <?php echo $rows['fname']; ?></a><span class='mx-1'><i class='fa-solid fa-calendar'></i> <?php echo $date; ?></span>
                </div>
                <img src="images/<?php echo $rows['pimage']; ?>" class="rounded mx-auto d-block w-50 my-5" alt="...">
                <p class="text-dark"><?php echo $rows['pdesc']; ?></p>
            </div>
            <?php include "parts/sidebar.php"; ?>
        </div>
    </div>
<?php include "parts/footer.php"; ?>