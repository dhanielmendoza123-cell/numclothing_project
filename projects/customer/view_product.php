<?php
// Include database connection
include_once __DIR__ . '/../shared/config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Num Apparel – Products</title>
    <link rel="stylesheet" href="view_product.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="logo">
            <img src="../uploads/numlogo.png" alt="Num logo" class="logo-img">
            <span class="logo-text">Num Clothing Apparel</span>
        </div>
        <ul class="nav-links">
            <li><a href="customerdashboard.php">Home</a></li>
            <li><a href="view_product.php">View Products</a></li>
            <li><a href="#">Profile</a></li>
        </ul>
    </nav>

    <!-- HERO SECTION -->
    <header class="hero" role="banner" aria-label="Collection hero">
        <div class="hero-inner">
            <h1>Discover Your Style</h1>
            <p>Explore our exclusive collection of premium apparel crafted for comfort and confidence.</p>
            <a class="cta" href="#products">Shop Collection</a>
        </div>
    </header>

    <!-- MAIN PRODUCT GRID -->
    <main class="product-section">
        <h2 class="section-title" id="products">Our Collection</h2>
        
        <div class="product-grid">
            <?php
            $query = "SELECT * FROM products ORDER BY product_id DESC";
            $result = mysqli_query($conn, $query);

            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    // Image path - uploads folder is at root level
                    if(!empty($row['image_url'])) {
                        // Database stores 'uploads/filename.jpg', so we need '../uploads/filename.jpg'
                        $imageSrc = '../' . $row['image_url'];
                    } else {
                        $imageSrc = '../uploads/placeholder.jpg';
                    }
                    
                    echo '
                    <div class="product-card">
                        <img src="'.htmlspecialchars($imageSrc).'" alt="'.htmlspecialchars($row['p_name']).'" onerror="this.onerror=null; this.src=\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22300%22 height=%22320%22%3E%3Crect fill=%22%232a2a2a%22 width=%22300%22 height=%22320%22/%3E%3Ctext fill=%22%23666%22 x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dominant-baseline=%22middle%22 font-family=%22Arial%22 font-size=%2218%22%3ENo Image%3C/text%3E%3C/svg%3E\';">
                        <div class="product-info">
                            <h3>'.htmlspecialchars($row['p_name']).'</h3>
                            <p>'.htmlspecialchars($row['description']).'</p>';
                    
                    // Show size if available
                    if(!empty($row['size'])) {
                        echo '<p class="size">Size: '.htmlspecialchars($row['size']).'</p>';
                    }
                    
                    echo '
                            <div class="price">₱'.number_format($row['price'], 2).'</div>
                            <button class="add-to-cart-btn" data-id="'.$row['product_id'].'" data-name="'.htmlspecialchars($row['p_name']).'" data-price="'.$row['price'].'">Add to Cart</button>
                        </div>
                    </div>
                    ';
                }
            } else {
                echo '<p style="color:white; text-align:center; grid-column: 1/-1; padding: 50px;">No products available at the moment. Check back soon!</p>';
            }
            
            mysqli_close($conn);
            ?>
        </div>
    </main>

    <!-- FOOTER -->
    <footer style="text-align: center; padding: 30px; background: #1a1a1a; margin-top: 50px; color: #888;">
        © <span id="year"></span> Num Clothing Apparel. All rights reserved.
    </footer>

    <script>
        document.getElementById('year').textContent = new Date().getFullYear();
        
        // Add to cart functionality
        document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const productId = this.getAttribute('data-id');
                const productName = this.getAttribute('data-name');
                const productPrice = this.getAttribute('data-price');
                
                // Change button text temporarily for feedback
                const originalText = this.textContent;
                const originalBg = this.style.backgroundColor;
                
                this.textContent = '✓ Added!';
                this.style.backgroundColor = '#4CAF50';
                this.style.color = 'white';
                
                setTimeout(() => {
                    this.textContent = originalText;
                    this.style.backgroundColor = originalBg;
                    this.style.color = '';
                }, 1500);
                
                // TODO: Implement actual cart functionality with AJAX
                console.log('Added to cart:', { 
                    id: productId, 
                    name: productName, 
                    price: productPrice 
                });
            });
        });
    </script>
</body>
</html>