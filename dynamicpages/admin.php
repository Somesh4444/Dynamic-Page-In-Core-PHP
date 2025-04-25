<?php
session_start(); // Must come first before using $_SESSION
include 'db.php';
$nav_pages = $conn->query("SELECT slug, title FROM pages ORDER BY id ASC");

// Delete page if requested
if (isset($_GET['delete'])) {
    $delete_id = (int) $_GET['delete'];
    $conn->query("DELETE FROM pages WHERE id = $delete_id");
    $_SESSION['message'] = "🗑️ Page deleted successfully.";
    header("Location: admin.php");
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $slug = $_POST['slug'];
    $content = $_POST['content'];

    $sql = "INSERT INTO pages (title, slug, content) VALUES ('$title', '$slug', '$content')";
    if ($conn->query($sql)) {
        $_SESSION['message'] = "✅ Page created successfully.";
    } else {
        $_SESSION['message'] = "❌ Error: " . $conn->error;
    }
    header("Location: admin.php");
    exit;
}

// Fetch all pages
$pages = $conn->query("SELECT * FROM pages ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Pages</title>
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
<nav class="navbar navbar-expand-lg navbar-dark bg-danger py-3">
    <div class="container">
        <a class="navbar-brand" href="index.php">Dynamic Page Builder</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a href="index.php" class="nav-link active">Home</a></li>
                <?php while ($row = $nav_pages->fetch_assoc()): ?>
                    <li class="nav-item">
                        <a class="nav-link mx-2" href="page.php?slug=<?= urlencode($row['slug']) ?>">
                            <?= htmlspecialchars($row['title']) ?>
                        </a>
                    </li>
                <?php endwhile; ?>
                <li class="nav-item">
                    <a href="index.php" class="btn btn-light ms-3">Go Back</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-5">
    <?php if (!empty($_SESSION['message'])): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <?= $_SESSION['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <div class="row">
        <!-- Form Column -->
        <div class="col-md-6">
            <h2 class="mb-4">Create a New Page</h2>
            <form method="POST" class="card p-4 shadow-sm mb-4 bg-white">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" required>
                    <div class="form-text">e.g., "about", "services", "contact"</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Content</label>
                    <textarea name="content" class="form-control" rows="5" required></textarea>
                </div>

                <button type="submit" class="btn btn-danger">Create Page</button>
            </form>
        </div>

        <!-- Table Column -->
        <div class="col-md-6">
            <h3 class="mb-4">All Pages</h3>
            <div class="card shadow-sm p-3 bg-white">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $pages->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= htmlspecialchars($row['title']) ?></td>
                                <td><?= htmlspecialchars($row['slug']) ?></td>
                                <td>
                                    <a href="page.php?slug=<?= urlencode($row['slug']) ?>" target="_blank" class="btn btn-sm btn-primary me-1">
                                        View
                                    </a>
                                    <a href="admin.php?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                                       onclick="return confirm('Are you sure you want to delete this page?');">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        <?php if ($pages->num_rows == 0): ?>
                            <tr>
                                <td colspan="4" class="text-center">No pages found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
