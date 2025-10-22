<?php
    include_once '../shared/config/path.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Combine all CSS files -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/admin/styles/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/admin/styles/sidebar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/admin/styles/main.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/admin/styles/forms.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/admin/styles/messages.css">

    <!-- Google Icons -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
    <!-- === SIDEBAR === -->
    <?php include ADMIN_PATH . '/components/sidebar.php'; ?>

    <!-- === MAIN CONTENT === -->
    <main class="main-content" id="main-content">
        <div class="default-message">
            <h1>Welcome to Admin Dashboard</h1>
            <p>Select a menu from the sidebar to begin.</p>
        </div>
    </main>

    <script src="<?= BASE_URL ?>/admin/script.js"></script>
</body>
</html>
