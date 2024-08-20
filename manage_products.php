<?php
include "db_connect.php";
$error = "";
$id = $_POST['pro_id'];
$category_name = trim($_POST['category_name']);
$product_name = trim($_POST['product_name']);
$price = trim($_POST['price']);
$stocks = trim($_POST['stocks']);
$image = $_FILES['image']['name'];
if (isset($_POST['submit']) && $_POST['submit'] == "create_product") {
    if (empty($category_name) || empty($product_name) || empty($price) || empty($stocks) || empty($image)) {
        echo $error = "empty";
    } else if (strlen($product_name) < 3) {
        echo $error =  "less";
    } else {
        if (empty($error)) {
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_error = $_FILES['image']['error'];
            $image_size = $_FILES['image']['size'];
            $image_name = explode(".", strtolower($image));
            $image_type = end($image_name);
            $accepted_files = array("jpg", "jpeg", "png");
            if (in_array($image_type, $accepted_files)) {
                if ($image_error < 1) {
                    if ($image_size < 15000) {
                        $new_image_name = uniqid("" . true);
                        $final_name = $new_image_name . "." . $image_type;
                        $target = "assets/upload/" . $final_name;
                        move_uploaded_file($image_tmp_name, $target);
                        $sql = "INSERT INTO `product`(`category_id`, `image`, `product_name`, `price`, `stocks`) 
                        VALUES ('$category_name','$final_name','$product_name','$price','$stocks')";
                        $result = $conn->query($sql) or die($conn->error);
                    } else {
                        echo $error = "size";
                    }
                } else {
                    echo $error = "error";
                }
            } else {
                echo $error = "type";
            }

        }
    }
} else if (isset($_POST['submit']) && $_POST['submit'] == "edit_product") {
    if (empty($category_name) || empty($product_name) || empty($price) || empty($stocks)) {
        echo $error = "empty";
    } else if (strlen($product_name) < 3) {
        echo $error = "less";
    } else {
        if (empty($image)) {
            $sql = "UPDATE `product` SET `category_id`='$category_name',`product_name`='$product_name',`price`='$price',`stocks`='$stocks' WHERE id=$id";
            $result = $conn->query($sql) or die($conn->error);
        } else {
            if (empty($error)) {
                $image_tmp_name = $_FILES['image']['tmp_name'];
                $image_error = $_FILES['image']['error'];
                $image_size = $_FILES['image']['size'];
                $image_name = explode(".", strtolower($image));
                $image_type = end($image_name);
                $accepted_files = array("jpg", "jpeg", "png");
                if (in_array($image_type, $accepted_files)) {
                    if ($image_error < 1) {
                        if ($image_size < 200000) {
                            $new_image_name = uniqid("" . true);
                            $final_name = $new_image_name . "." . $image_type;
                            $target = "assets/upload/" . $final_name;
                            move_uploaded_file($image_tmp_name, $target);
                            $product_image = $conn->query("SELECT `image` FROM `product` WHERE id=$id") or die($conn->error);
                            $row = $product_image->fetch_assoc();
                            $path = "assets/upload/".$row['image'];
                            unlink($path);
                            $sql = "UPDATE `product` SET `category_id`='$category_name',`image`='$final_name', `product_name`='$product_name',`price`='$price',`stocks`='$stocks' WHERE id=$id";
                            $result = $conn->query($sql) or die($conn->error);
                        } else {
                            echo $error = "size";
                        }
                    } else {
                        echo $error = "error";
                    }
                } else {
                    echo $error = "type";
                }

            }
        }
    }
}
?>