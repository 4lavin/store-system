<?php
include "db_connect.php";
$id = $_POST['id'];
if (isset($_POST['delete_items']) && $_POST['delete_items'] == "delete_category") {
    $sql = "DELETE FROM `category` WHERE id = $id";
    $result = $conn->query($sql) or die($conn->error);
    $total_rows = $conn->query("SELECT * FROM `category`") or die($conn->error);
    echo $total_rows->num_rows;
} elseif (isset($_POST['delete_items']) && $_POST['delete_items'] == "delete_product") {
    $product = $conn->query("SELECT * FROM `product` WHERE id=$id") or die($conn->error);
    $row = $product->fetch_assoc();
    $path = "assets/upload/" . $row['image'];
    unlink($path);
    $sql = "DELETE FROM `product` WHERE id = $id";
    $result = $conn->query($sql) or die($conn->error);
    $total_rows = $conn->query("SELECT * FROM `product`") or die($conn->error);
    echo $total_rows->num_rows;
} elseif (isset($_POST['delete_items']) && $_POST['delete_items'] == "delete_orders") {
    $sql = "DELETE FROM `order` WHERE id = $id";
    $result = $conn->query($sql) or die($conn->error);
    $total_rows = $conn->query("SELECT * FROM `product`") or die($conn->error);
    echo $total_rows->num_rows;
} elseif (isset($_POST['delete_items']) && $_POST['delete_items'] == "delete_users") {
    $sql = "DELETE FROM `user` WHERE id = $id";
    $result = $conn->query($sql) or die($conn->error);
    $total_rows = $conn->query("SELECT * FROM `user`") or die($conn->error);
    echo $total_rows->num_rows;
}
?>