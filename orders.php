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
                    <h5 class="card-title m-0"><b>Products</b></h5>
                </div>
                <table class="table table-striped table-bordered">
                    <colgroup>
                        <col width="10%">
                        <col width="17.5%">
                        <col width="17.5%">
                        <col width="17.5%">
                        <col width="17.5%">
                        <col width="20%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Order Details</th>
                            <th>User Details</th>
                            <th>Total</th>
                            <th>Status</th>
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

                        $category = $conn->query("SELECT * FROM `order`") or die($conn->error);
                        $total_rows = $category->num_rows;
                        $total_page_no = ceil($total_rows / 5);

                        $sql = "SELECT * FROM `category` 
                        INNER JOIN `product` ON category.id = product.category_id
                        INNER JOIN `order` ON product.id = order.product_id
                        INNER JOIN `user` ON order.user_id = user.id
                        LIMIT $offset, 5";
                        $result = $conn->query($sql) or die($conn->error);

                        if ($result->num_rows < 1) { ?>
                            <tr>
                                <td style="color: #B2BEB5" colspan="7"><small><i>-- empty database --</i></small></td>
                            </tr>
                        <?php } else {
                            while ($row = $result->fetch_assoc()):
                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td>
                                        <img src="assets/upload/<?php echo $row['image']; ?>" alt="" width="50px" height="50px">
                                        <div class="d-flex justify-content-between">
                                            <small>Product </small><small><?php echo $row['product_name']; ?></small>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <small>Category </small><small><?php echo $row['category_name']; ?></small>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <small>Quantity </small><small><?php echo $row['quantity']; ?></small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-between">
                                            <small>Name </small><small><?php echo $row['name']; ?></small>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <small>Address </small><small><?php echo $row['address']; ?></small>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <small>Cp. No. </small><small><?php echo $row['number']; ?></small>
                                        </div>
                                    </td>
                                    <td><?php echo $row['total']; ?></td>
                                    <td>
                                        <?php if ($row['status'] == "pending") { ?>
                                            <small class="px-4 py-2 mb-2 bg-warning text-white rounded-pill">Pending</small>
                                        <?php } ?>
                                        <?php if ($row['status'] == "waiting") { ?>
                                            <small class="px-5 py-2 mb-2 bg-primary text-white rounded-pill">Waiting</small>
                                        <?php } ?>
                                        <?php if ($row['status'] == "delivered") { ?>
                                            <small class="px-4 py-2 mb-2 bg-success text-white rounded-pill">Delivered</small>
                                        <?php } ?>
                                    </td>
                                    <td>
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
                                <a class="page-link" href="product.php?page_no=<?php echo $prev_page_no ?>"
                                    tabindex="-1">&laquo;</a>
                            </li>
                            <?php
                            for ($counter = 1; $counter <= $total_page_no; $counter++) {
                                if ($counter == $page_no) { ?>
                                    <li class="page-item active"><a class="page-link"><?php echo $counter ?></a></li>
                                <?php } else { ?>
                                    <li class="page-item"><a class="page-link"
                                            href="product.php?page_no=<?php echo $counter ?>"><?php echo $counter ?></a>
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
                        data: { id: id, delete_items: "delete_orders" },
                        success: function (data) {
                            if (data == 0) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your file has been deleted.",
                                    icon: "success"
                                });
                                setInterval(function () {
                                    location.href = `orders.php?page_no=${Math.ceil(data + 1 / 5)}`
                                }, 1000);
                            }
                            else {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your file has been deleted.",
                                    icon: "success"
                                });
                                setInterval(function () {
                                    location.href = `orders.php?page_no=${Math.ceil(data / 5)}`
                                }, 1000);
                            }
                        }
                    })
                }
            });
        })
    })
</script>

<?php
include "footer.php";
?>