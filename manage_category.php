<?php
include "db_connect.php";
$error = "";
$category_name = trim($_POST['category_name']);
$id = $_POST['cat_id'];
if (isset($_POST['submit']) && $_POST['submit'] == "create_category") {
    if (empty($_POST['category_name'])) {
        echo $error = "empty";
    } else if (strlen($category_name) < 3) {
        echo $error = "less";
    } else {
        if (empty($error)) {
            $sql = "INSERT INTO `category`(`category_name`) VALUES ('$category_name')";
            $result = $conn->query($sql) or die($conn->error);
        }
    }
} else if (isset($_POST['submit']) && $_POST['submit'] == "edit_category") {
    if (empty($_POST['category_name'])) {
        echo $error = "empty";
    } else {
        $category_name = trim($_POST['category_name']);
        if (strlen($category_name) < 3) {
            echo $error = "less";
        }
    }
    if (empty($error)) {
        $sql = "UPDATE `category` SET `category_name`='$category_name' WHERE id = $id";
        $result = $conn->query($sql) or die($conn->error);
    }
} else {
    header("location: category.php");
}
?>