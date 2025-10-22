<?php
include_once __DIR__ . '/../../../shared/config/db.php';
include_once __DIR__ . '/../../../shared/config/path.php';

if (!isset($_GET['id'])) {
    echo "<p>Product ID is missing.</p>";
    exit;
}

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM products WHERE product_id = $id");

if ($result->num_rows == 0) {
    echo "<p>Product not found.</p>";
    exit;
}

$product = $result->fetch_assoc();
$error_message = '';
$success_message = '';

if (isset($_POST['submit'])) {
    $name = $conn->real_escape_string($_POST['p_name']);
    $price = $conn->real_escape_string($_POST['price']);
    $size = $conn->real_escape_string($_POST['size']);
    $desc = $conn->real_escape_string($_POST['description']);
    $imagePath = $product['image_url'];

    // Handle new image upload
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
       $uploadDir = __DIR__ . '/../../../uploads/';
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileExtension = strtolower(pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION));
        $fileName = uniqid() . '_' . time() . '.' . $fileExtension;
        $uploadFile = $uploadDir . $fileName;

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $maxFileSize = 5 * 1024 * 1024;
        
        if (in_array($fileExtension, $allowedTypes) && $_FILES['product_image']['size'] <= $maxFileSize) {
            // Delete old image if exists
            if ($product['image_url'] && file_exists(__DIR__ . '/../../../' . $product['image_url'])) {
                unlink(__DIR__ . '/../../../' . $product['image_url']);
            }

            if (move_uploaded_file($_FILES['product_image']['tmp_name'], $uploadFile)) {
                $imagePath = 'uploads/' . $fileName;
                $success_message = "Image updated successfully!";
            } else {
                $error_message = "Failed to upload new image.";
            }
        } else {
            $error_message = "Invalid file type or file too large.";
        }
    }

    if (empty($error_message)) {
        $sql = "UPDATE products SET 
                    p_name='$name',
                    price='$price',
                    size='$size',
                    description='$desc',
                    image_url='$imagePath'
                WHERE product_id=$id";

        if ($conn->query($sql)) {
            $success_message = "Product updated successfully!";
            // Refresh product data
            $result = $conn->query("SELECT * FROM products WHERE product_id = $id");
            $product = $result->fetch_assoc();
        } else {
            $error_message = "Error: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/admin/styles/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/admin/styles/sidebar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/admin/styles/main.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/admin/styles/forms.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/admin/styles/messages.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" rel="stylesheet">
</head>
<body>
   <?php include_once __DIR__ . '/../../components/sidebar.php'; ?>

    <main class="main-content">
        <div class="card">
            <div class="card-header">
                Edit Product
            </div>
            <div class="card-body">
                <!-- Display Messages -->
                <?php if ($error_message): ?>
                    <div class="message error-message">
                        <span class="material-symbols-rounded">error</span>
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($success_message): ?>
                    <div class="message success-message">
                        <span class="material-symbols-rounded">check_circle</span>
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>

                <form class="product-form form-layout" action="" method="POST" enctype="multipart/form-data">
                    
                    <div class="form-left">
                        <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" name="p_name" value="<?= htmlspecialchars($product['p_name']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Size</label>
                            <input type="text" name="size" value="<?= htmlspecialchars($product['size']) ?>">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" rows="4"><?= htmlspecialchars($product['description']) ?></textarea>
                        </div>
                    </div>

                    <div class="form-right">
                        <label class="image-upload-label">Product Image</label>
                        <small style="color: #888; display: block; margin-bottom: 10px;">Current image will be replaced</small>
                        
                        <div id="imagePreviewBox" class="image-preview-box <?php echo !empty($product['image_url']) ? 'has-image' : ''; ?>">
                            <img 
                                id="previewImg" 
                                class="preview-image <?php echo !empty($product['image_url']) ? 'show' : ''; ?>" 
                                src="<?php echo !empty($product['image_url']) ? BASE_URL . '/' . $product['image_url'] : ''; ?>" 
                                alt="Preview"
                            >

                            <?php if (empty($product['image_url'])): ?>
                                <div id="placeholder" class="preview-placeholder">
                                    <span class="material-symbols-rounded">image</span>
                                    <p>No image selected</p>
                                </div>
                            <?php else: ?>
                                <div id="placeholder" class="preview-placeholder" style="display:none;">
                                    <span class="material-symbols-rounded">image</span>
                                    <p>No image selected</p>
                                </div>
                            <?php endif; ?>

                            <button id="removeImage" class="remove-image <?php echo !empty($product['image_url']) ? 'show' : ''; ?>">
                                <span class="material-symbols-rounded">close</span>
                            </button>
                        </div>



                        <div class="file-input-wrapper">
                            <input type="file" id="productImage" name="product_image" accept="image/*">
                            <label for="productImage" class="custom-file-button">
                                <span class="material-symbols-rounded">upload</span>
                                Choose New Image
                            </label>
                        </div>
                        
                        <?php if ($product['image_url']): ?>
                            <div style="margin-top: 10px; font-size: 0.85rem; color: #888;">
                                Current: <?= basename($product['image_url']) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="form-actions-grid">
                        <button type="submit" name="submit" class="btn">UPDATE PRODUCT</button>
                        <a href="product_list.php" class="btn cancel">BACK TO LIST</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script src="<?= BASE_URL ?>/admin/script.js"></script>
</body>
</html>