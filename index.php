<?php
    // Đọc dữ liệu tin tức từ file JSON
    $myFile = fopen("admin/news.json", "r");
    $filesize = filesize("admin/news.json");
    if ($filesize > 0) {
        $newsData = json_decode(fread($myFile, $filesize), true);
    }

    // Sắp xếp tin theo ngày (mới nhất lên đầu)
    usort($newsData, function ($a, $b) {
        $timeA = strtotime(str_replace('/', '-', $a['date']));
        $timeB = strtotime(str_replace('/', '-', $b['date']));
        return $timeB - $timeA;
    });
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo Cũ - Trang chủ</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Inter:wght@400;500&display=swap" rel="stylesheet">

    <style>
        /* ==================== CƠ BẢN ==================== */
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

        /* ==================== NAVBAR ==================== */
        .navbar {
            background-color: var(--card-bg);
            transition: background-color 0.4s;
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

        /* ==================== TÌM KIẾM ==================== */
        #searchInput {
            max-width: 300px;
            border-radius: 20px;
        }

        /* ==================== CARD TIN TỨC ==================== */
        .news-card {
            background-color: var(--card-bg);
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .news-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 6px 18px rgba(0,0,0,0.15);
        }
        .news-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }
        .card-title {
            font-family: "Merriweather", serif;
            transition: color 0.3s;
        }
        [data-theme="dark"] .card-title {
            color: var(--accent) !important;
        }
        [data-theme="light"] .card-title {
            color: #212529 !important;
        }
        [data-theme="dark"] .text-muted,
        [data-theme="dark"] .text-secondary {
            color: var(--muted) !important;
        }

        /* ==================== FOOTER ==================== */
        footer {
            border-top: 1px solid var(--muted);
            color: var(--muted);
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <!-- ==================== NAVBAR ==================== -->
    <nav class="navbar navbar-expand-lg shadow-sm sticky-top">
        <div class="container d-flex justify-content-between align-items-center py-2">
            <div>
                <a class="navbar-brand" href="index.php">🗞️ Báo Cũ</a><br>
                <small>Nhanh hơn Báo Mới</small>
            </div>
            <div class="d-flex align-items-center gap-2">
                <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Tìm bài viết...">
                <button id="themeToggle" class="btn btn-outline-primary btn-sm" title="Đổi chế độ">
                    🌙
                </button>
            </div>
        </div>
    </nav>

    <!-- ==================== DANH SÁCH TIN TỨC ==================== -->
    <div class="container my-4">
        <h3 class="text-center mb-4 fw-bold">Tin tức mới nhất</h3>
        <div class="row" id="newsContainer">
            <?php if (!empty($newsData)): ?>
                <?php foreach ($newsData as $news): ?>
                    <div class="col-md-4 mb-4 news-item">
                        <a href="news-detail.php?id=<?= $news['id'] ?>" class="text-decoration-none">
                            <div class="card news-card h-100">
                                <img src="<?= 'admin/' . $news['image'] ?>" alt="<?= $news['title'] ?>">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><?= $news['title'] ?></h5>
                                    <p class="text-muted small mb-1"><?= $news['category'] ?> | <?= $news['author'] ?></p>
                                    <p class="text-end text-secondary small mt-auto"><?= $news['date'] ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center text-muted py-5">
                    <p>Hiện chưa có bài viết nào.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ==================== FOOTER ==================== -->
    <footer class="text-center py-3">
        🗞️ Báo Cũ — Nhanh hơn Báo Mới © 2025
    </footer>

    <!-- ==================== SCRIPT ==================== -->
    <script>
        // Fade-in khi load trang
        window.addEventListener("load", () => {
            document.body.classList.add("loaded");
        });

        // Toggle Dark/Light Mode
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

        // Tìm kiếm realtime theo tiêu đề
        const searchInput = document.getElementById("searchInput");
        const newsItems = document.querySelectorAll(".news-item");

        searchInput.addEventListener("input", () => {
            const search = searchInput.value.toLowerCase();
            newsItems.forEach(item => {
                const title = item.querySelector(".card-title").textContent.toLowerCase();
                item.style.display = title.includes(search) ? "" : "none";
            });
        });
    </script>
</body>
</html>
