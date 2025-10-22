<?php
    include_once '../../../shared/config/path.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product List</title>
   <link rel="stylesheet" href="<?= BASE_URL ?>/admin/styles/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/admin/styles/sidebar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/admin/styles/main.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/admin/styles/forms.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/admin/styles/messages.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" rel="stylesheet">
</head>
<body>
    <?php include ADMIN_PATH . '/components/sidebar.php'; ?>

    <main class="main-content">
        <div class="card">
            <div class="card-header">
                <h2>Product List</h2>
            </div>

            <div class="card-body">
                <div class="button-row">
                    <a href="product_create.php" class="add-btn">
                        <span class="material-symbols-rounded">add_circle</span>
                        CREATE NEW PRODUCT
                    </a>
                </div>

                <table class="product-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Size</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include_once '../../../shared/config/db.php';
                        $result = $conn->query("SELECT * FROM products");
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$row['product_id']}</td>
                                    <td>{$row['p_name']}</td>
                                    <td>₱{$row['price']}</td>
                                    <td>{$row['size']}</td>
                                    <td>{$row['description']}</td>
                                    <td>
                                        <a href='product_edit.php?id={$row['product_id']}' class='edit-btn'>
                                            <span class='material-symbols-rounded'>edit_square</span>
                                            Edit
                                        </a>
                                        <a href='product_delete.php?id={$row['product_id']}' class='delete-btn' onclick='return confirm(\"Delete this product?\")'>
                                            <span class='material-symbols-rounded'>delete</span>
                                            Delete
                                        </a>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No products found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

   <script src="<?= BASE_URL ?>/admin/script.js"></script>
</body>
</html>
