<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// === Correct includes ===
include_once __DIR__ . '/../../../shared/config/path.php';
include_once __DIR__ . '/../../../shared/config/db.php';

$error_message = '';
$success_message = '';

if (isset($_POST['submit'])) {
    $name = $conn->real_escape_string($_POST['p_name']);
    $price = $conn->real_escape_string($_POST['price']);
    $size = $conn->real_escape_string($_POST['size']);
    $desc = $conn->real_escape_string($_POST['description']);
    $imagePath = null;

    // === Handle image upload ===
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../../uploads/'; // absolute path for uploads folder
        
        // Create uploads directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                $error_message = "Failed to create upload directory.";
            }
        }

        // Check if directory is writable
        if (!is_writable($uploadDir)) {
            $error_message = "Upload directory is not writable.";
        } else {
            $fileExtension = strtolower(pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION));
            $fileName = uniqid() . '_' . time() . '.' . $fileExtension;
            $uploadFile = $uploadDir . $fileName;

            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $maxFileSize = 5 * 1024 * 1024; // 5MB
            
            if (!in_array($fileExtension, $allowedTypes)) {
                $error_message = "Invalid file type. Only JPG, JPEG, PNG, GIF, and WEBP are allowed.";
            } elseif ($_FILES['product_image']['size'] > $maxFileSize) {
                $error_message = "File is too large. Maximum size is 5MB.";
            } elseif (move_uploaded_file($_FILES['product_image']['tmp_name'], $uploadFile)) {
                // Set relative path for database
                $imagePath = 'uploads/' . $fileName;
                $success_message = "Image uploaded successfully!";
            } else {
                $error_message = "Failed to upload image. Error: " . $_FILES['product_image']['error'];
            }
        }
    } elseif ($_FILES['product_image']['error'] !== UPLOAD_ERR_NO_FILE) {
        $uploadErrors = [
            UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize in php.ini',
            UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE in form',
            UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
            UPLOAD_ERR_EXTENSION => 'PHP extension stopped the file upload'
        ];
        $error_message = $uploadErrors[$_FILES['product_image']['error']] ?? 'Unknown upload error';
    }

    // === Insert into database ===
    if (empty($error_message)) {
        if ($imagePath) {
            $sql = "INSERT INTO products (p_name, price, size, description, image_url) 
                    VALUES ('$name', '$price', '$size', '$desc', '$imagePath')";
        } else {
            $sql = "INSERT INTO products (p_name, price, size, description) 
                    VALUES ('$name', '$price', '$size', '$desc')";
        }

        if ($conn->query($sql)) {
            $success_message = "Product created successfully!";
            echo "<script>
                setTimeout(function() {
                    window.location.href = 'product_list.php';
                }, 1000);
            </script>";
        } else {
            $error_message = "Database error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
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
                Create New Product
            </div>
            <div class="card-body">
                <!-- Display Messages -->
                <?php if ($error_message): ?>
                    <div class="message error-message">
                        <span class="material-symbols-rounded">error</span>
                        <?= $error_message; ?>
                    </div>
                <?php endif; ?>

                <?php if ($success_message): ?>
                    <div class="message success-message">
                        <span class="material-symbols-rounded">check_circle</span>
                        <?= $success_message; ?>
                    </div>
                <?php endif; ?>

                <form class="product-form form-layout" action="product_create.php" method="POST" enctype="multipart/form-data">
                    <div class="form-left">
                        <div class="form-group">
                            <label>Product Name *</label>
                            <input type="text" name="p_name" value="<?= htmlspecialchars($_POST['p_name'] ?? '') ?>" placeholder="Product Name" required>
                        </div>
                        <div class="form-group">
                            <label>Price *</label>
                            <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($_POST['price'] ?? '') ?>" placeholder="0.00" required>
                        </div>
                        <div class="form-group">
                            <label>Size</label>
                            <input type="text" name="size" value="<?= htmlspecialchars($_POST['size'] ?? '') ?>" placeholder="e.g., S, M, L, XL">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" placeholder="Product description" rows="4"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <div class="form-right">
                        <label class="image-upload-label">Product Image</label>
                        <small style="color: #888; display: block; margin-bottom: 10px;">Supported formats: JPG, PNG, GIF, WEBP (Max: 5MB)</small>

                        <div class="image-preview-box" id="imagePreviewBox">
                            <div class="preview-placeholder" id="placeholder">
                                <span class="material-symbols-rounded">image</span>
                                <p>Image Preview</p>
                            </div>
                            <img id="previewImg" class="preview-image" src="" alt="Preview">
                            <button type="button" class="remove-image" id="removeImage">
                                <span class="material-symbols-rounded">close</span>
                            </button>
                        </div>

                        <div class="file-input-wrapper">
                            <input type="file" id="productImage" name="product_image" accept="image/*">
                            <label for="productImage" class="custom-file-button">
                                <span class="material-symbols-rounded">upload</span>
                                Choose Image
                            </label>
                        </div>
                    </div>

                    <div class="form-actions-grid">
                        <button type="submit" name="submit" class="btn">CREATE PRODUCT</button>
                        <a href="product_list.php" class="btn cancel">BACK TO LIST</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="<?= BASE_URL ?>/admin/script.js"></script>
</body>
</html>