<?php
include "db_connect.php";
$error = "";
$id = $_POST['use_id'];
$name = trim($_POST['name']);
$address = trim($_POST['address']);
$number = trim($_POST['number']);
$username = trim($_POST['username']);
$old_number = trim($_POST['old_number']);
$old_username = trim($_POST['old_username']);
$password = trim($_POST['password']);
$type = trim($_POST['type']);
if (isset($_POST['submit']) && $_POST['submit'] == "create_user") {
    if (empty($name) || empty($address) || empty($number) || empty($username) || empty($password) || empty($type)) {
        echo $error = "empty";
    } else if (strlen($name) < 3 || strlen($address) < 5 || strlen($number) <= 5 || strlen($username) < 3 || strlen($password) < 5) {
        echo $error = "less";
    } else {
        if (empty($error)) {
            $check = $conn->query("SELECT * FROM `user` WHERE username = '$username' OR number = '$number'") or die($conn->error);
            $row = $check->num_rows;
            if ($row > 0) {
                echo $error = "used";
            } else {
                $sql = "INSERT INTO `user`( `name`, `address`, `number`, `username`, `password`, `type`) 
                VALUES ('$name','$address','$number','$username','$password','$type')";
                $result = $conn->query($sql) or die($conn->error);
            }

        }
    }
} else if (isset($_POST['submit']) && $_POST['submit'] == "edit_user") {
    if (empty($name) || empty($address) || empty($number) || empty($username) || empty($password) || empty($type)) {
        echo $error = "empty";
    } else if (strlen($name) < 3 || strlen($address) < 5 || strlen($number) <= 5 || strlen($username) < 3 || strlen($password) < 5) {
        echo $error = "less";
    } else {
        if (empty($error)) {
            $usernamee = $conn->query("SELECT * FROM `user` WHERE username = '$old_username'") or die($conn->error);
            $user_row = $usernamee->fetch_assoc();
            if ($user_row['username'] == $username && $user_row['number'] == $number) {
                $result = $conn->query("UPDATE `user` SET `name`='$name',`address`='$address',`number`='$number',`username`='$username',`password`='$password',`type`='$type' 
                WHERE id ='$id'") or die($conn->error);
            } else if ($user_row['username'] != $username && $user_row['number'] != $number) {
                $usernamee = $conn->query("SELECT * FROM `user` WHERE username = '$username'") or die($conn->error);
                $user_row = $usernamee->num_rows;
                $numberr = $conn->query("SELECT * FROM `user` WHERE number = '$number'") or die($conn->error);
                $num_row = $numberr->num_rows;
                if ($user_row > 0 && $num_row > 0) {
                    echo "used num and user";
                } else if ($user_row > 0) {
                    echo "used user";
                } else if ($num_row > 0) {
                    echo "used num";
                } else {
                    $result = $conn->query("UPDATE `user` SET `name`='$name',`address`='$address',`number`='$number',`username`='$username',`password`='$password',`type`='$type' 
                    WHERE id ='$id'") or die($conn->error);
                }
            } else if ($user_row['username'] != $username) {
                $usernamee = $conn->query("SELECT * FROM `user` WHERE username = '$username'") or die($conn->error);
                $user_row = $usernamee->num_rows;
                if ($user_row > 0) {
                    echo "used user";
                } else {
                    $result=$conn->query("UPDATE `user` SET `name`='$name',`address`='$address',`number`='$number',`username`='$username',`password`='$password',`type`='$type' 
                    WHERE id ='$id'") or die($conn->error);
                }
            } else if ($user_row['number'] != $number) {
                $usernamee = $conn->query("SELECT * FROM `user` WHERE number = '$number'") or die($conn->error);
                $user_row = $usernamee->num_rows;
                if ($user_row > 0) {
                    echo "used num";
                } else {
                    $result=$conn->query("UPDATE `user` SET `name`='$name',`address`='$address',`number`='$number',`username`='$username',`password`='$password',`type`='$type' 
                    WHERE id ='$id'") or die($conn->error);
                }
            }

        }
    }
}

?>