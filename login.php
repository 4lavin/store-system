<?php
session_start();
include "db_connect.php";
include "header.php";
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM `user` WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql) or die($conn->error);
    $row = $result->fetch_assoc();
    if ($result->num_rows > 0) {
        $_SESSION['name'] = $row['name'];
        $_SESSION['type'] = $row['type'];
        header("location: index.php?page=dashboard");
    }

}
?>
<div class="d-flex justify-content-center align-items-center" style="height: 100vh">
    <div class="d-flex justify-content-center align-items-center wrapper">
        <div class="form-container login">
            <img src="assets/store.png" alt="" style="width: 200px; display: block; margin: auto;">
            <form action="login.php" method="post">
                <div class="form-group mb-3">
                    <input type="text" id="username" name="username" placeholder="">
                    <label>Username</label>
                </div>
                <div class="form-group mb-3">
                    <input type="password" id="password" name="password" placeholder="">
                    <label>Password</label>
                </div>
                <button type="submit" name="login">Submit</button>
            </form>
            <div class="mt-2">
                <p><small>Dont have an account?&nbsp;<a class="register_btn">Register</a></small></p>
            </div>
        </div>
        <div class="form-container register">
            <img src="assets/store.png" alt="" style="width: 200px; display: block; margin: auto;">
            <form name="register" id="register">
                <div class="form-group mb-2">
                    <input type="text" id="name" name="name" placeholder="">
                    <label>Name</label>
                </div>
                <div class="form-group mb-2">
                    <input type="text" id="address" name="address" placeholder="">
                    <label>Adress</label>
                </div>
                <div class="form-group mb-2">
                    <input type="text" id="number" name="number" placeholder="">
                    <label>Cellphone Number</label>
                </div>
                <div class="form-group mb-2">
                    <input type="text" id="register_username" name="register_username" placeholder="">
                    <label>Username</label>
                </div>
                <div class="form-group mb-2">
                    <input type="password" id="register_password" name="register_password" class="show" placeholder="">
                    <label>Password</label>
                </div>
                <div class="form-group">
                    <input type="password" id="re_password" name="re_password" class="show" placeholder="">
                    <label>Re-Password</label>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <input class="me-2" type="checkbox" id="view_pass">
                    <label for=""><small>See Password</small></label>
                </div>
                <button type="submit">Submit</button>
            </form>
            <div class="mt-2">
                <p><small>Dont have an account?&nbsp;<a class="login_btn">Login</a></small></p>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(".register_btn").click(function () {
            $(".wrapper").addClass("active")
        })
        $(".login_btn").click(function () {
            $(".wrapper").removeClass("active")
        })
        $("#view_pass").click(function () {
            if (this.checked == true) {
                $(".show").each(function (params) {
                    $(this).attr("type", "type")
                })
            }
            else {
                $(".show").each(function (params) {
                    $(this).attr("type", "password")
                })
            }
        })
        $("#register").submit(function (e) {
            e.preventDefault()
            let data = new FormData(this)
            data.append("register" , "register")
            $.ajax({
                type: "POST",
                url: "registered_user.php",
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    console.log(data);

                }
            })
        })
    })
</script>
<?php
include "footer.php";
?>