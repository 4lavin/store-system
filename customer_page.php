<?php
include "db_connect.php";
include "header.php";
?>
<div class="topbar d-flex justify-content-between align-items-center">
    <img src="assets/store.png" alt="" width="50px" height="50px">
    <div class="m-0 topbar-container">
        <p class="menu-text">Menu</p>
        <li><a href="">
                <i class="fa-solid fa-basket-shopping"></i>
                <span class="label">Cart</span>
                <span class="sub">Cart</span>
            </a>
        </li>
        <li>
            <a href="">
                <i class="fa-brands fa-shopify"></i>
                <span class="label">Orders</span>
                <span class="sub">Orders</span>
            </a>
        </li>
        <li>
            <a href="" class="profile">
                <i class="fa-solid fa-user"></i>
                <span class="label">Profile</span>
                <span class="sub">Profile</span>
            </a>
        </li>
        <div class="close"><i class="fa-solid fa-xmark"></i></div>
    </div>
</div>
<div class="main-container">
    <div class="container">
        <div class="grid-container">
            <?php
            $sql = "SELECT * FROM `category` INNER JOIN `product` ON product.category_id = category.id";
            $result = $conn->query($sql) or die ($conn->error);
            while($row = $result->fetch_assoc()) :
            ?>
            <div class="grid">
                <div class="image">
                    <img src="assets/upload/<?php echo $row['image'] ?>" alt="">
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="m-0"><?php echo $row['category_name'] ?></small>
                        <p class="m-0"><b><?php echo $row['product_name'] ?></b></p>
                        <p class="m-0">₱ <?php echo $row['price'] ?>.00</p>
                    </div>
                    <i class="fa-solid fa-basket-shopping" onclick="addToCart(<?php echo $row['id'] ?>)"></i>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>
<script>
    function addToCart(id) {
        console.log(id);
    }
</script>
<?php
include "footer.php";
?>