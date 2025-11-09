<?php
    session_start();
    unset($_SESSION['isLoggedIn']);
    echo '<script>
        alert("Đăng xuất thành công");
        window.location.href = "index.php";
    </script>';