<?php
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    if (isset($_POST['submit'])) {
        $image = $_FILES['image'];
        $imageName = $image['name'];
        $imageTmp = $image['tmp_name'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $category = $_POST['category'];
        $author = 'Admin';
        $currentDate = date('d/m/Y H:i:s');
        $checkUploadFile = move_uploaded_file($imageTmp, "uploads/$imageName");
        if ($checkUploadFile) {
            $data = [
                'image' => "uploads/$imageName",
                'title' => $title,
                'content' => $content,
                'category' => $category,
                'author' => $author,
                'date' => $currentDate
            ];
            $myfile = fopen("news.json", "r");
            $filesize = filesize("news.json");
            $newsData = [];
            if ($filesize > 0) {
                $newsData = json_decode(fread($myfile, $filesize));
                $data['id'] = count($newsData) + 1;
                array_push($newsData, $data);
            } else {
                $data['id'] = 1;
                array_push($newsData, $data);
            }

            $myfile = fopen("news.json", "w");
            fwrite($myfile, json_encode($newsData));
            fclose($myfile);

            echo '<script>
                alert("Đăng bài thành công!");
                window.location.href="news_add.php";
            </script>';
        } else {
            echo '<script>
                alert("Có lỗi xảy ra!");
                window.location.href="news_add.php";
            </script>';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm tin tức</title>
    <?php include '../inc/style.php' ?>
</head>
<body>
    <?php include '../inc/admin/menu.php' ?>
    <div class="container">
        <h3 class="text-center mt-3 mb-3">Thêm tin tức</h3>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mt-3 mb-3">
                <label>Ảnh <span class="text-danger">*</span></label>
                <input type="file" class="form-control" accept="image/*" name="image" required>
            </div>
            <div class="mt-3 mb-3">
                <label>Tiêu đề <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Nhập tiêu đề" name="title" required>
            </div>
            <div class="mt-3 mb-3">
                <label>Nội dung <span class="text-danger">*</span></label>
                <textarea class="form-control" rows="10" name="content" required></textarea>
            </div>
            <div class="mt-3 mb-3">
                <label>Danh mục <span class="text-danger">*</span></label>
                <select class="form-control" name="category" required>
                    <option value="">Vui lòng chọn danh mục</option>
                    <option value="Thể thao">Thể thao</option>
                    <option value="Giáo dục">Giáo dục</option>
                    <option value="Kinh tế">Kinh tế</option>
                    <option value="Khoa học">Khoa học</option>
                    <option value="Xã hội">Xã hội</option>
                </select>
            </div>
            <div class="mt-3 mb-3">
                <button type="submit" name="submit" class="btn btn-primary">Đăng bài</button>
            </div>
        </form>
    </div>
</body>
</html>