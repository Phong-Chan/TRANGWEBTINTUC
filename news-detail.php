<?php
    // Lấy id bài viết
    $id = $_GET['id'];
    $myfile = fopen("admin/news.json", "r");
    $filesize = filesize("admin/news.json");
    if ($filesize > 0) {
        $newsData = json_decode(fread($myfile, $filesize), true);
    }

    // Tìm bài viết theo id
    $newsDetail = null;
    foreach ($newsData as $news) {
        if ($news['id'] == $id) {
            $newsDetail = $news;
            break;
        }
    }
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $newsDetail ? $newsDetail['title'] : "Không tìm thấy bài viết" ?> - Báo Cũ</title>

    <!-- Bootstrap + Font -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Inter:wght@400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg: #ffffff;
            --text: #212529;
            --muted: #6c757d;
            --accent: #4c9aff;
            --card-bg: #f8f9fa;
        }
        [data-theme="dark"] {
            --bg: #1c1f26;
            --text: #e9ecef;
            --muted: #adb5bd;
            --accent: #4c9aff;
            --card-bg: #2a2f3a;
        }

        body {
            background-color: var(--bg);
            color: var(--text);
            font-family: "Inter", sans-serif;
            opacity: 0;
            transition: opacity 0.8s ease, background-color 0.4s, color 0.4s;
        }
        body.loaded {
            opacity: 1;
        }

        .navbar {
            background-color: var(--card-bg);
        }
        .navbar-brand {
            font-family: "Merriweather", serif;
            font-size: 1.5rem;
            color: var(--accent) !important;
        }
        .navbar small {
            font-size: 0.8rem;
            color: var(--muted);
        }

        img {
            border-radius: 10px;
            max-height: 450px;
            object-fit: cover;
        }

        footer {
            border-top: 1px solid var(--muted);
            color: var(--muted);
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar shadow-sm">
        <div class="container d-flex justify-content-between align-items-center py-2">
            <div>
                <a class="navbar-brand" href="index.php">🗞️ Báo Cũ</a><br>
                <small>Nhanh hơn Báo Mới</small>
            </div>
            <button id="themeToggle" class="btn btn-outline-primary btn-sm">🌙</button>
        </div>
    </nav>

    <!-- CHI TIẾT TIN -->
    <div class="container my-5">
        <?php if ($newsDetail): ?>
            <h1 class="mb-3 fw-bold"><?= $newsDetail['title'] ?></h1>
            <p class="text-muted small mb-4">
                <?= $newsDetail['category'] ?> | <?= $newsDetail['author'] ?> | <?= $newsDetail['date'] ?>
            </p>
            <img src="<?= 'admin/' . $newsDetail['image'] ?>" class="mb-4 w-100" alt="">
            <p style="white-space: pre-line;"><?= $newsDetail['content'] ?></p>
        <?php else: ?>
            <div class="alert alert-warning">Không tìm thấy bài viết.</div>
        <?php endif; ?>
    </div>

    <footer class="text-center py-3">
        🗞️ Báo Cũ — Nhanh hơn Báo Mới © 2025
    </footer>

    <script>
        // Fade-in khi load
        window.addEventListener("load", () => {
            document.body.classList.add("loaded");
        });

        // Toggle dark/light mode
        const toggleBtn = document.getElementById("themeToggle");
        const currentTheme = localStorage.getItem("theme") || "light";
        document.documentElement.setAttribute("data-theme", currentTheme);
        toggleBtn.textContent = currentTheme === "dark" ? "☀️" : "🌙";

        toggleBtn.addEventListener("click", () => {
            const theme = document.documentElement.getAttribute("data-theme") === "dark" ? "light" : "dark";
            document.documentElement.setAttribute("data-theme", theme);
            localStorage.setItem("theme", theme);
            toggleBtn.textContent = theme === "dark" ? "☀️" : "🌙";
        });
    </script>
</body>
</html>
