<?php include 'db.php'; ?>

<?php
$nav_pages = $conn->query("SELECT slug, title FROM pages ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                    <a href="admin.php" class="btn btn-light ms-3">Add a Page</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- ✅ Static Home Content -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 text-center">
            <h1>Welcome Home</h1>
            <hr>
            <p>Create and manage dynamic pages using Core PHP.</p>
        </div>
        <div class="col-12">
            <!-- Lottie animation container -->
            <div id="lottie-animation" style="width: 100%; height: 350px; margin-top: 20px;"></div>
        </div>
    </div>
</div>

<footer class="bg-dark text-white fixed-bottom py-4">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
        <!-- Left: Contact Paragraph -->
        <p class="mb-2 mb-md-0">Contact us at: ofcsomu@gmail.com | i’d love to hear from you!</p>

        <!-- Right: Social Icons -->
        <div>
            <a href="https://github.com/Somesh4444" class="text-white text-decoration-none me-3" target="_blank">
                <i class="fab fa-github fa-lg"></i>
            </a>
            <a href="https://codepen.io/-Lipunn" class="text-white text-decoration-none" target="_blank">
                <i class="fab fa-codepen fa-lg"></i>
            </a>
        </div>
    </div>
</footer>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lottie-web@5.7.13/build/player/lottie.min.js"></script>
<script>
    var animation = lottie.loadAnimation({
        container: document.getElementById('lottie-animation'), // Container to display the animation
        renderer: 'svg', // Render method: 'svg' or 'canvas'
        loop: true, // Set to 'true' for looping
        autoplay: true, // Set to 'true' for autoplay
        path: 'homeicon.json' // Path to your Lottie JSON file
    });
</script>


</body>
</html>
