<?php
// Include database connection
include_once __DIR__ . '/../shared/config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard - Num Apparel</title>
    <link rel="stylesheet" href="cdashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="logo">
             <img src="<?= BASE_URL ?>/shared/images/numlogo.png" alt="logo" class="logo-img">
            <span class="logo-text">Num Clothing Apparel</span>
        </div>
        <ul class="nav-links">
            <li><a href="customerdashboard.php">Home</a></li>
            <li><a href="view_product.php">View Products</a></li>
            <li><a href="#">Profile</a></li>
        </ul>
    </nav>

    <div class="hero-section">
        <div class="hero-content">
            <h1>Your Style, Your Power</h1>
            <p>Discover premium streetwear that defines confidence, individuality, and next-level fashion.</p>
            <a href="view_product.php">Shop Now</a>
        </div>
    </div>

    <div id="dashboard" class="dashboard-container">
        <div class="card">
            <h3>View Products</h3>
            <p>Explore the latest arrivals</p>
            <a href="view_product.php" class="card-btn">Go</a>
        </div>

        <div class="card">
            <h3>My Orders</h3>
            <p>Track your recent purchases</p>
            <a href="#" class="card-btn">View</a>
        </div>

        <div class="card">
            <h3>Cart</h3>
            <p>Items waiting for checkout</p>
            <a href="#" class="card-btn">Open</a>
        </div>

        <div class="card">
            <h3>Profile</h3>
            <p>Manage your account</p>
            <a href="#" class="card-btn">Edit</a>
        </div>
    </div>
</body>
</html>