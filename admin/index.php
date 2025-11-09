<?php
    session_start();
    if (isset($_SESSION['isLoggedIn'])){
        echo '<script>
            window.location.href = "news.php";
        </script>';
    }


    if (isset($_POST['submit'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passAdminHash = '$2y$10$mYIgNW/xzfRBWgu9LAxVPOmwVCSDjQJLWRkhDUVAaQT0mBhoVcsNm'; 
        if ($email == 'admin@gmail.com' && password_verify($password, $passAdminHash)){
            $_SESSION['isLoggedIn'] = true;
            echo '<script>
                alert("Đăng nhập thành công!");
                window.location.href = "news.php";
                </script>';
        } else{
            echo '<script>
                alert("Đăng nhập thất bại");
                window.location.href="index.php";
            </script>';
            // ko co comment
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <?php include '../inc/style.php'?>
</head>
<body>
    <body style="background-color: rgb(89, 200, 255);">
    <div class="container">
        <h1 class="text-center mt-3">Đăng nhập quản trị viên</h1>
        <form action="" method="POST">
            <div class="row flex-column align-items-center">
                <div class="col-md-6">
                    <div class="mt-3 mb-3">
                        <label>Email: <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" placeholder="Nhập email của bạn">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mt-3 mb-3">
                        <label>Mật khẩu: <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu của bạn">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mt-3 mb-3">
                        <button type="submit" name="submit" class="btn btn-primary">Đăng nhập</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>