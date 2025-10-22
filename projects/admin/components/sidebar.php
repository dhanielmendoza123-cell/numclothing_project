<?php 
include_once __DIR__ . '/../../shared/config/path.php'; // adjust path based on sidebar.php location

$currentPage = basename($_SERVER['PHP_SELF']); 
?>


<aside class="sidebar">
    <header class="sidebar-header">
        <div class="logo-container">
            <img src="<?= BASE_URL ?>/shared/images/numlogo.png" alt="Logo" class="sidebar-logo">
        </div>
        <button class="toggler sidebar-toggler">
            <span class="material-symbols-rounded">menu</span>
        </button>
    </header>

    <nav class="sidebar-nav">
        <ul class="nav-list primary-nav">
            <li class="nav-item">
                <a href="<?= BASE_URL ?>/admin/index.php" class="nav-link <?= ($currentPage == 'index.php') ? 'active' : ''; ?>">
                    <span class="nav-icon material-symbols-rounded">dashboard</span>
                    <span class="nav-label">Dashboard</span>
                </a>
                <span class="nav-tooltip">Dashboard</span>
            </li>

            <li class="nav-item">
                <a href="<?= BASE_URL ?>/admin/pages/customer.php" class="nav-link <?= ($currentPage == 'customer.php') ? 'active' : ''; ?>">
                    <span class="nav-icon material-symbols-rounded">group</span>
                    <span class="nav-label">Customer</span>
                </a>
                <span class="nav-tooltip">Customer</span>
            </li>

            <li class="nav-item">
                <a href="<?= BASE_URL ?>/admin/pages/orders.php" class="nav-link <?= ($currentPage == 'orders.php') ? 'active' : ''; ?>">
                    <span class="nav-icon material-symbols-rounded">orders</span>
                    <span class="nav-label">Order</span>
                </a>
                <span class="nav-tooltip">Order</span>
            </li>

            <li class="nav-item">
                <a href="<?= BASE_URL ?>/admin/pages/products/product_list.php" class="nav-link <?= in_array($currentPage, ['product_list.php','product_create.php','product_edit.php']) ? 'active' : ''; ?>">
                    <span class="nav-icon material-symbols-rounded">apparel</span>
                    <span class="nav-label">Product</span>
                </a>
                <span class="nav-tooltip">Product</span>
            </li>

            <li class="nav-item">
                <a href="<?= BASE_URL ?>/admin/pages/sales.php" class="nav-link <?= ($currentPage == 'sales.php') ? 'active' : ''; ?>">
                    <span class="nav-icon material-symbols-rounded">chart_data</span>
                    <span class="nav-label">Sales Report</span>
                </a>
                <span class="nav-tooltip">Sales Report</span>
            </li>

            <li class="nav-item">
                <a href="<?= BASE_URL ?>/admin/pages/inventory.php" class="nav-link <?= ($currentPage == 'inventory.php') ? 'active' : ''; ?>">
                    <span class="nav-icon material-symbols-rounded">inventory</span>
                    <span class="nav-label">Inventory</span>
                </a>
                <span class="nav-tooltip">Inventory</span>
            </li>
        </ul>

        <ul class="nav-list secondary-nav">
            <li class="nav-item">
                <a href="<?= BASE_URL ?>/admin/pages/profile.php" class="nav-link <?= ($currentPage == 'profile.php') ? 'active' : ''; ?>">
                    <span class="nav-icon material-symbols-rounded">account_circle</span>
                    <span class="nav-label">Profile</span>
                </a>
                <span class="nav-tooltip">Profile</span>
            </li>
            <li class="nav-item">
                <a href="<?= BASE_URL ?>/admin/pages/logout.php" class="nav-link <?= ($currentPage == 'logout.php') ? 'active' : ''; ?>">
                    <span class="nav-icon material-symbols-rounded">logout</span>
                    <span class="nav-label">Logout</span>
                </a>
                <span class="nav-tooltip">Logout</span>
            </li>
        </ul>
    </nav>
</aside>
