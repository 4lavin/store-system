<?php include "header.php" ?>
<div class="sidebar pt-4">
    <div class="nav-container mt-4">
        <div class="d-flex align-items-center justify-content-around">
            <img src="assets/upload/store.png" class="rounded-circle me-1" alt="" width="50px" height="50px">
        </div>
        <hr>
        <li>
            <a href="index.php?page=dashboard" class="nav-dashboard">   
                <i class="fa-solid fa-chart-pie"></i>
                <span class="desc">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="category.php?page=category" class="nav-category">
                <i class="fa-solid fa-clipboard-list"></i>
                <span class="desc">Category</span>
            </a>
        </li>
        <li>
            <a href="products.php?page=products" class="nav-products">
                <i class="fa-solid fa-bag-shopping"></i>
                <span class="desc">Products</span>
            </a>
        </li>
        <li>
            <a href="orders.php?page=orders" class="nav-orders">
                <i class="fa-brands fa-shopify"></i>
                <span class="desc">Orders</span>
            </a>
        </li>
        <li>
            <a href="cart.php?page=cart" class="nav-cart">
                <i class="fa-solid fa-basket-shopping"></i>
                <span class="desc">Cart</span>
            </a>
        </li>
        <li>
            <a href="users.php?page=users" class="nav-users">
                <i class="fa-solid fa-user"></i>
                <span class="desc">Users</span>
            </a>
        </li>
        <hr>
        <li>
            <a href="logout.php" class="nav-logout">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span class="desc">Logout</span>
            </a>
        </li>
    </div>
</div>
<script>
    $(".nav-<?php echo isset($_GET['page']) ? $_GET['page'] : "" ?>").addClass("nav-active")
</script>