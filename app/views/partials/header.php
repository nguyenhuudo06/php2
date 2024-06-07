<div class="container-fluid fixed-top">
    <div class="container topbar bg-primary d-none d-lg-block">
        <div class="d-flex justify-content-between">
            <div class="top-info ps-2">
                <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white">123 Street, New York</a></small>
                <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white">Email@Example.com</a></small>
            </div>
            <div class="top-link pe-2">
                <a href="#" class="text-white"><small class="text-white mx-2">Privacy Policy</small>/</a>
                <a href="#" class="text-white"><small class="text-white mx-2">Terms of Use</small>/</a>
                <a href="#" class="text-white"><small class="text-white ms-2">Sales and Refunds</small></a>
            </div>
        </div>
    </div>
    <div class="container px-0">
        <nav class="navbar navbar-light bg-white navbar-expand-xl">
            <a href="<?php echo (_WEB_ROOT_) ?>" class="navbar-brand">
                <h1 class="text-primary display-6">Do Fresh</h1>
            </a>
            <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars text-primary"></span>
            </button>
            <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                <div class="navbar-nav mx-auto">
                    <a href="<?php echo (_WEB_ROOT_) ?>" class="nav-item nav-link active">Home</a>
                    <a href="" class="nav-item nav-link">Product</a>
                    <a href="shop-detail.html" class="nav-item nav-link">Shop Detail</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                        <div class="dropdown-menu m-0 bg-secondary rounded-0">
                            <a href="cart.html" class="dropdown-item">Cart</a>
                            <a href="chackout.html" class="dropdown-item">Chackout</a>
                            <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                            <a href="404.html" class="dropdown-item">404 Page</a>
                        </div>
                    </div>
                    <a href="contact.html" class="nav-item nav-link">Contact</a>
                </div>
                <?php if (!isset($_SESSION['user_id'])) { ?>
                    <div class="navbar-nav ml-auto">
                        <button class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fas fa-search text-primary"></i></button>
                        <a href="#" class="nav-item nav-link"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
                        <a href="<?php echo _WEB_ROOT_ ?>/auth/login" class="nav-item nav-link">Login</a>
                        <a href="<?php echo _WEB_ROOT_ ?>/auth/register" class="nav-item nav-link">Register</a>
                    </div>
                <?php } else { ?>
                    <div class="navbar-nav ml-auto">
                        <a href="<?php echo _WEB_ROOT_ ?>/auth/logout" class="nav-item nav-link">Đăng xuất</a>
                    </div>
                <?php } ?>
            </div>
        </nav>
    </div>
</div>