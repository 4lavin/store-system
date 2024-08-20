<?php
session_start();
include "db_connect.php";
include "header.php";
include "navbar.php";
if (isset($_SESSION['name'])) {
} else {
    header("location: login.php");
}
?>
<main class="mt-3">
    <div class="main-container">
        <div class="">
            <div class="card-body">
                <!--  -->
                <h5 class="card-title mb-3"><b>Users</b></h5>
                <hr>
                <div class="d-flex justify-content-end align-items-center my-3">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn text-white px-4" style="background: #002147;"
                        data-bs-toggle="modal" id="create_btn">
                        <small>Create User</small>
                    </button>
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="" id="create">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">User</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="error ps-4 text-danger"></div>
                                        <select class="form-select" id="type" name="type">
                                            <option value="">- Select Type -</option>
                                            <option value="customer">Customer</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                        <div class="form-group my-3">
                                            <input type="text" id="name" name="name" placeholder="">
                                            <label>Name</label>
                                            <input type="text" id="use_id" name="use_id" placeholder="" hidden>
                                        </div>
                                        <div class="form-group my-3">
                                            <input type="text" id="address" name="address" placeholder="">
                                            <label>Address</label>
                                        </div>
                                        <div class="form-group my-3">
                                            <input type="number" id="number" name="number" placeholder="">
                                            <label>Cellphone Number</label>
                                            <input type="text" id="old_number" placeholder="" hidden>
                                            <input type="text" id="old_username" placeholder="" hidden>
                                        </div>
                                        <div class="form-group my-3">
                                            <input type="text" id="username" name="username" placeholder="">
                                            <label>Username</label>
                                        </div>
                                        <div class="form-group mt-3">
                                            <input type="password" id="password" name="password" placeholder="">
                                            <label>Password</label>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <input class="me-2" type="checkbox" id="view_pass">
                                            <label for=""><small>See Password</small></label>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                            id="close">Close</button>
                                        <button type="submit" class="btn btn-primary" id="save">Save</button>
                                        <button type="submit" class="btn btn-primary" id="save_changes">Save
                                            Changes</button>
                                        <input type="text" name="submit" id="submit" placeholder="" hidden>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered">
                    <colgroup>
                        <col width="10%">
                        <col width="23.3%">
                        <col width="23.3%">
                        <col width="23.3%">
                        <col width="23.3%">
                        <col width="23.3%">
                        <col width="23.3%">
                        <col width="30%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>User Details</th>
                            <th>Contact</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_GET['page_no'])) {
                            $page_no = $_GET['page_no'];
                            $i = ($page_no - 1) * 5 + 1;
                        } else {
                            $i = 1;
                            $page_no = 1;
                        }
                        $prev_page_no = $page_no - 1;
                        $next_page_no = $page_no + 1;
                        $offset = ($page_no - 1) * 5;

                        $category = $conn->query("SELECT * FROM `user`") or die($conn->error);
                        $total_rows = $category->num_rows;
                        $total_page_no = ceil($total_rows / 5);

                        $sql = "SELECT * FROM `user` LIMIT $offset, 5";
                        $result = $conn->query($sql) or die($conn->error);

                        if ($result->num_rows < 1) { ?>
                            <tr>
                                <td style="color: #B2BEB5" colspan="3"><small><i>-- empty database --</i></small></td>
                            </tr>
                        <?php } else {
                            while ($row = $result->fetch_assoc()):
                                ?>
                                <tr>
                                    <td hidden>
                                        <small><?php echo $row['name']; ?></small>
                                        <small><?php echo $row['username']; ?></small>
                                        <small><?php echo $row['password']; ?></small>
                                        <small><?php echo $row['address']; ?></small>
                                        <small><?php echo $row['number']; ?></small>
                                        <small><?php echo $row['type']; ?></small>
                                    </td>
                                    <td data-label="No."><?php echo $i++; ?></td>
                                    <td>
                                        <div class="d-flex justify-content-between ">
                                            <small>Name </small><small><?php echo $row['name']; ?></small>
                                        </div>
                                        <div class="d-flex justify-content-between ">
                                            <small>Username </small><small><?php echo $row['username']; ?></small>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <small>Password </small><small><?php echo $row['password']; ?></small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-between">
                                            <small>Address </small><small>
                                                <p class="text-end m-0"><?php echo $row['address']; ?></p>
                                            </small>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <small>Number </small><small><?php echo $row['number']; ?></small>
                                        </div>
                                    </td>
                                    <td data-label="Type"><small><?php echo $row['type']; ?></small></td>
                                    <td data-label="Action">
                                        <button type="button" class="btn btn-outline-primary edit_btn"
                                            data-label="<?php echo $row['id'] ?>">
                                            <i class="ri-edit-box-line"></i>
                                        </button>
                                        <button class="btn btn-outline-danger delete_btn" data-label="<?php echo $row['id'] ?>">
                                            <i class="ri-close-circle-line"></i></button>
                                    </td>
                                </tr>
                            <?php endwhile;
                        } ?>
                    </tbody>
                </table>
                <?php if ($result->num_rows < 1) {
                } else { ?>
                    <nav aria-label="Page navigation example d">
                        <ul class="pagination d-flex justify-content-end">
                            <li class="page-item <?php echo isset($page_no) && $page_no <= 1 ? "disabled" : '' ?>">
                                <a class="page-link" href="category.php?page_no=<?php echo $prev_page_no ?>"
                                    tabindex="-1">&laquo;</a>
                            </li>
                            <?php
                            for ($counter = 1; $counter <= $total_page_no; $counter++) {
                                if ($counter == $page_no) { ?>
                                    <li class="page-item active"><a class="page-link"><?php echo $counter ?></a></li>
                                <?php } else { ?>
                                    <li class="page-item"><a class="page-link"
                                            href="category.php?page_no=<?php echo $counter ?>"><?php echo $counter ?></a>
                                    </li>
                                <?php }
                            } ?>
                            <li
                                class="page-item <?php echo isset($page_no) && $page_no == $total_page_no ? "disabled" : '' ?>">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                <?php } ?>
            </div>
        </div>
    </div>
</main>
<script>
    $(document).ready(function () {
        $("#view_pass").click(function () {
            if (this.checked == true) {
                $("#password").attr("type", "type")
            }
            else {
                $("#password").attr("type", "password")
            }
        })
        $("#create_btn").click(function () {
            $("#exampleModal").modal("show")
            $("#save").show()
            $("#save_changes").hide()
            $("#submit").val("create_user")
        })
        $(".edit_btn").click(function () {
            $("#exampleModal").modal("show")
            $("#save").hide()
            $("#save_changes").show()
            let id = $(this).attr("data-label")
            let tr = $(this).closest("tr")
            let user = tr.children("td").children("small").map(function () {
                return $(this).text();
            }).get();
            $("#name").val(user[0].trim())
            $("#username").val(user[1].trim())
            $("#password").val(user[2].trim())
            $("#address").val(user[3].trim())
            $("#number").val(user[4].trim())
            $("#type").val(user[5].trim())
            $("#old_number").val(user[4].trim())
            $("#old_username").val(user[1].trim())
            $("#use_id").val(id)
            $("#submit").val("edit_user")
        })
        $(".delete_btn").click(function () {
            let id = $(this).attr("data-label")
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "delete.php",
                        data: { id: id, delete_items: "delete_users" },
                        success: function (data) {
                            if (data == 0) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your file has been deleted.",
                                    icon: "success"
                                });
                                setInterval(function () {
                                    location.href = `users.php?page_no=${Math.ceil(data + 1 / 5)}`
                                }, 1000);
                            }
                            else {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your file has been deleted.",
                                    icon: "success"
                                });
                                setInterval(function () {
                                    location.href = `users.php?page_no=${Math.ceil(data / 5)}`
                                }, 1000);
                            }
                        }
                    })
                }
            });
        })
        $("#create").submit(function (e) {
            e.preventDefault()
            let old_username = $("#old_username").val()
            let old_number = $("#old_number").val()
            let data = new FormData(this)
            data.append("old_number", old_number)
            data.append("old_username", old_username)
            $.ajax({
                type: "POST",
                url: "manage_users.php",
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data == "empty") {
                        $(".error").html("<small>Don't leave empty space</small>")
                    }
                    else if (data == "less") {
                        $(".error").html("<small>Atleast 3 or more letters</small>")
                    }
                    else if (data == "used num") {
                        $(".error").html("<small>Cellphone number is used")
                    }
                    else if (data == "used user") {
                        $(".error").html("<small>Username is used</small>")
                    }
                    else if (data == "used num and user") {
                        $(".error").html("<small>Username and Cellphone number is used</small>")
                    }
                    else {
                        $("#exampleModal").modal("hide")
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Your work has been saved",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setInterval(function () {
                            location.reload();
                        }, 1000);
                    }
                }
            })

        })
    })
</script>
<?php 
include "footer.php";
?>