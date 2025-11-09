<?php
    $id = $_GET['id'];
    $myfile = fopen("news.json", "r");
    $filesize = filesize("news.json");
    if ($filesize > 0) {
        $newsData = json_decode(fread($myfile, $filesize), true);
    }

    foreach ($newsData as $key => $news) {
        if ($news['id'] == $id) {
            $newsDetail = $newsData[$key];
            break;
        }
    }

    if (isset($_POST['submit'])) {
        $image = $_FILES['image'];
        $imageName = $image['name'];
        $imageTmp = $image['tmp_name'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $category = $_POST['category'];
        $checkUploadFile = move_uploaded_file($imageTmp, "uploads/$imageName");
        foreach ($newsData as $key => $news) {
            if ($news['id'] == $id) {
                $newsData[$key]['title'] = $title;
                $newsData[$key]['content'] = $content;
                $newsData[$key]['category'] = $category;
                if ($checkUploadFile) {
                    $newsData[$key]['image'] = "uploads/$imageName";
                }
            }
        }

        $myfile = fopen("news.json", "w");
        fwrite($myfile, json_encode($newsData));
        fclose($myfile);

        echo '<script>
            alert("Cập nhật thành công!");
            window.location.href="news.php";
        </script>';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật tin tức</title>
    <?php include '../inc/style.php' ?>
</head>
<body>
    <?php include '../inc/admin/menu.php' ?>
    <div class="container">
        <h3 class="text-center mt-3 mb-3">Cập nhật tin tức</h3>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mt-3 mb-3">
                <label>Ảnh</label>
                <input type="file" class="form-control" accept="image/*" name="image">
                <div class="mt-3">
                    <img src="<?= $newsDetail['image'] ?>" width="150" class="border">
                </div>
            </div>
            <div class="mt-3 mb-3">
                <label>Tiêu đề <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Nhập tiêu đề" name="title" value="<?= $newsDetail['title'] ?>" required>
            </div>
            <div class="mt-3 mb-3">
                <label>Nội dung <span class="text-danger">*</span></label>
                <textarea class="form-control" rows="10" name="content" required><?= $newsDetail['content'] ?></textarea>
            </div>
            <div class="mt-3 mb-3">
                <label>Danh mục <span class="text-danger">*</span></label>
                <select class="form-control" name="category" required>
                    <option value="">Vui lòng chọn danh mục</option>
                    <option value="Thể thao" <?= $newsDetail['category'] == "Thể thao" ? "selected" : "" ?>>Thể thao</option>
                    <option value="Giáo dục" <?= $newsDetail['category'] == "Giáo dục" ? "selected" : "" ?>>Giáo dục</option>
                    <option value="Kinh tế" <?= $newsDetail['category'] == "Kinh tế" ? "selected" : "" ?>>Kinh tế</option>
                    <option value="Khoa học" <?= $newsDetail['category'] == "Khoa học" ? "selected" : "" ?>>Khoa học</option>
                    <option value="Xã hội" <?= $newsDetail['category'] == "Xã hội" ? "selected" : "" ?>>Xã hội</option>
                </select>
            </div>
            <div class="mt-3 mb-3">
                <button type="submit" name="submit" class="btn btn-primary">Cập nhật</button>
            </div>
        </form>
    </div>
</body>
</html>