<?php
    $myfile = fopen("news.json","r");
    $filesize = filesize("news.json");
    if ($filesize > 0){
        $newsData = json_decode(fread($myfile, $filesize),true);
    }

    usort($newsData, function ($a, $b){
        $timeA = strtotime(str_replace('/','-',$a['date']));
        $timeB = strtotime(str_replace('/','-',$b['date']));
        return $timeB - $timeA;
    });

    session_start();
    if(!isset($_SESSION['isLoggedIn'])) {
        echo '<script>
            alert("Vui lòng đăng nhập!");
            window.location.href = "index.php";
        <script>';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include '../inc/style.php'?>
</head>
<body>
    <?php include '../inc/admin/menu.php'?>
    <div class = "container">
        <h3 class = "text-center mt-3 mb-3">Danh sách tin tức</h3>
        <a href="news_add.php" class="btn btn-primary mb-3">Thêm tin tức</a>
        <table id="Table_of_news" class = "table table-bordered">
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Tiêu đề</th>
                    <th>Nội dung</th>
                    <th>Danh mục</th>
                    <th>Tác giả</th>
                    <th>Ngày đăng</th>
                    <th width = "130">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($newsData as $item): ?>
                    <tr>
                        <td>
                            <img src="<?= $item["image"] ?>" width="100">
                        </td>
                        <td><?= $item['title'] ?></td>
                        <td><?= $item['content'] ?></td>
                        <td><?= $item['category'] ?></td>
                        <td><?= $item['author'] ?></td>
                        <td><?= $item['date'] ?></td>
                        <td>
                            <a href="news_delete.php?id=<?= $item['id']?>" class="btn btn-danger">Xóa</a>
                            <a href="news_edit.php?id=<?= $item['id']?>" class="btn btn-success">Sửa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include '../inc/script.php'?>
    <script>
        $(document).ready(function(){
            $('#Table_of_news').DataTable();
        });
    </script>
</body>
</html>