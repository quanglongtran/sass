<?php
require_once('connect.php');


if (isset($_GET['page'])) {
    $current_page = $_GET['page'];
} else {
    $current_page = 1;
}
$item_per_page = 5;
$offset = ($current_page - 1) * $item_per_page;
$total_page = mysqli_num_rows(mysqli_query($conn, 'select * from sanpham')) / $item_per_page;
$total_page = ceil($total_page);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
<div class="container">
    <div class="row">
        <?php
        $sql = 'select * from sanpham limit ?, ?';
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, 'ss', $offset, $item_per_page);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col col-lg-3">
                <div class="card">
                    <img src="<?= $row['thumbnail'] ?>" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['title'] ?></h5>
                        <p class="card-text">
                            Price: <?= $row['price'] ?> VND<br>Discount:
                            <del style="color: red"><?= $row['discount'] ?> VND</del>
                        </p>
                        <a href="#" class="btn btn-primary">Buy now</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <nav aria-label="Page navigation example">
        <p>Current Page: <?=$current_page?></p>
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link" href="?page=1" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li id="prev" class="page-item"><a class="page-link" href="?page=<?=$current_page - 1?>">Previous</a></li>
            <?php for ($i = 1; $i <= $total_page; $i++) {
                if ($current_page == $total_page) {
                    $last_page = true;
                } else {
                    $last_page = false;
                }
                if ($current_page == 1) {
                    $first_page = true;
                } else {
                    $first_page = false;
                }
                if ($i != $current_page) {
                    if ($i > $current_page -3 && $i < $current_page +3) {
                ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?=$i?>"><?=$i?></a>
                </li>
            <?php } } else { ?>
            <strong><li class="page-item">
                <a class="page-link" href="?page=<?=$i?>"><?=$i?></a>
            </li></strong>
            <?php } } ?>
            <li id="next" class="page-item"><a class="page-link" href="?page=<?=$current_page + 1?>">Next</a></li>
            <li class="page-item">
                <a class="page-link" href="?page=<?=$total_page?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
</body>
<script>
    if ('<?=$first_page?>' == 1) {
        $('#prev').addClass('disabled');
    }

    if ('<?=$last_page?>' == 1) {
        $('#next').addClass('disabled');
    }
</script>
</html>