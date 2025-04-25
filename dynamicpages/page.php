<?php include 'db.php'; ?>

<?php
$slug = $_GET['slug'] ?? '';

// Fetch current page
$page_result = $conn->query("SELECT * FROM pages WHERE slug = '$slug'");
$page = $page_result->fetch_assoc();

// Fetch all pages for the navbar
$nav_pages = $conn->query("SELECT slug, title FROM pages ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $page ? htmlspecialchars($page['title']) : 'Page Not Found' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
    <style>
        body{
            font-family: "Source Code Pro", monospace;
        }
    </style>
</head>
<body class="bg-light">

<!-- ✅ Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-danger py-3">
    <div class="container">
        <a class="navbar-brand" href="index.php">My Dynamic Site</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
                <?php while ($row = $nav_pages->fetch_assoc()): ?>
                    <li class="nav-item">
                        <a class="nav-link mx-2 <?= ($row['slug'] === $slug) ? 'active' : '' ?>" href="page.php?slug=<?= urlencode($row['slug']) ?>">
                            <?= htmlspecialchars($row['title']) ?>
                        </a>
                    </li>
                <?php endwhile; ?>
                <li class="nav-item">
                    <a href="admin.php" class="btn btn-light ms-3">Add a Page</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- ✅ Page Content -->
<div class="container mt-5">
    <?php if ($page): ?>
        <div class="card shadow-sm p-4">
            <h1><?= htmlspecialchars($page['title']) ?></h1>
            <hr>
            <p><?= nl2br(htmlspecialchars($page['content'])) ?></p>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">
            <h2>404 - Page Not Found</h2>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
