<?php
include_once __DIR__ . '/../../../shared/config/db.php';
$id = $_GET['id'];

$conn->query("DELETE FROM products WHERE product_id=$id");
header("Location: product_list.php");
exit;
?>
