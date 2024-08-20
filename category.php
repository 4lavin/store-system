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
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title m-0"><b>Category</b></h5>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn text-white px-4" style="background: #002147;"
                        data-bs-toggle="modal" id="create_btn">
                        <small>Create Category</small>
                    </button>
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="" id="create">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Category</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="error ps-4 text-danger"></div>
                                        <div class="form-group my-3">
                                            <input type="text" id="category_name" name="category_name" placeholder="">
                                            <input type="text" id="cat_id" name="cat_id" placeholder="" hidden>
                                            <label>Category</label>
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
                        <col width="70%">
                        <col width="20%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Category</th>
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

                        $category = $conn->query("SELECT * FROM `category`") or die($conn->error);
                        $total_rows = $category->num_rows;
                        $total_page_no = ceil($total_rows / 5);

                        $sql = "SELECT * FROM `category` LIMIT $offset, 5";
                        $result = $conn->query($sql) or die($conn->error);

                        if ($result->num_rows < 1) { ?>
                            <tr>
                                <td style="color: #B2BEB5" colspan="3"><small><i>-- empty database --</i></small></td>
                            </tr>
                        <?php } else {
                            while ($row = $result->fetch_assoc()):
                                ?>
                                <tr>
                                    <td data-label="No."><?php echo $i++; ?></td>
                                    <td data-label="Category"><small><?php echo $row['category_name']; ?></small></td>
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
        $("#create_btn").click(function () {
            $("#exampleModal").modal("show")
            $("#save").show()
            $("#save_changes").hide()
            $("#submit").val("create_category")
        })
        $(".edit_btn").click(function () {
            $("#exampleModal").modal("show")
            $("#save").hide()
            $("#save_changes").show()
            let id = $(this).attr("data-label")
            let tr = $(this).closest("tr")
            let data = tr.children("td").map(function () {
                return $(this).text();
            }).get();
            $("#category_name").val(data[1])
            $("#cat_id").val(id)
            $("#submit").val("edit_category")
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
                        data: { id: id, delete_items: "delete_category" },
                        success: function (data) {
                            if (data == 0) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your file has been deleted.",
                                    icon: "success"
                                });
                                setInterval(function () {
                                    location.href = `category.php?page_no=${Math.ceil(data+1 / 5)}`
                                }, 1000);
                            }
                            else {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your file has been deleted.",
                                    icon: "success"
                                });
                                setInterval(function () {
                                    location.href = `category.php?page_no=${Math.ceil(data / 5)}`
                                }, 1000);
                            }
                        }
                    })
                }
            });
        })
        $("#create").submit(function (e) {
            e.preventDefault()
            $.ajax({
                type: "POST",
                url: "manage_category.php",
                data: new FormData(this),
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