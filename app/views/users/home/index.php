<?php
$this->render('partials/slider');
?>

<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <div class="tab-class text-center">
            <div class="row g-4">
                <div class="col-lg-4 text-start">
                    <h1>Our Products</h1>
                </div>
                <div class="col-lg-8 text-end">
                    <ul class="nav nav-pills d-inline-flex text-center mb-5">
                        <li class="nav-item">
                            <a class="d-flex m-2 py-2 bg-light rounded-pill active" data-bs-toggle="pill" href="#tab-1">
                                <span class="text-dark" style="width: 130px;">All Products</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="d-flex m-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-2">
                                <span class="text-dark" style="width: 130px;">Most views</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="d-flex m-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-3">
                                <span class="text-dark" style="width: 130px;">Best seller</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="d-flex m-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-4">
                                <span class="text-dark" style="width: 130px;">Less common</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane fade show p-0 active">
                    <div class="row g-4">
                        <div class="col-lg-12">
                            <div class="row g-4">
                                <?php foreach ($all as $dataItem) { ?>
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <img style="with: 100%; height: 240px; object-fit: cover; object-position: center;" src="<?php echo ($dataItem['img']) ?>" class="img-fluid w-100 rounded-top" alt="">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;"><?php echo ($dataItem['category_name']) ?></div>
                                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 50px; left: 10px;"><i class="fa-regular fa-eye"></i> <?php echo ($dataItem['views']) ?></div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4><?php echo ($dataItem['name']) ?></h4>
                                                <p>Quantity: <?php echo ($dataItem['quantity']) ?></p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-0"><?php echo ($dataItem['price']) ?> VNĐ</p>
                                                </div>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <a href="<?php echo (_WEB_ROOT_ . '/products/details?id=' . $dataItem['id']) ?>" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-eye" aria-hidden="true"></i> View</a>
                                                    <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tab-2" class="tab-pane fade show p-0">
                    <div class="row g-4">
                        <div class="col-lg-12">
                            <div class="row g-4">
                                <?php foreach ($mostViews as $dataItem) { ?>
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <img src="<?php echo ($dataItem['img']) ?>" class="img-fluid w-100 rounded-top" alt="">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;"><?php echo ($dataItem['category_name']) ?></div>
                                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 50px; left: 10px;">Views: <?php echo ($dataItem['views']) ?></div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4><?php echo ($dataItem['name']) ?></h4>
                                                <p>Quantity: <?php echo ($dataItem['quantity']) ?></p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-0"><?php echo ($dataItem['price']) ?> VNĐ</p>
                                                </div>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-eye" aria-hidden="true"></i> View</a>
                                                    <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tab-3" class="tab-pane fade show p-0">
                    <div class="row g-4">
                        <div class="col-lg-12">
                            <div class="row g-4">
                                <?php foreach ($lessCommon as $dataItem) { ?>
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <img src="<?php echo ($dataItem['img']) ?>" class="img-fluid w-100 rounded-top" alt="">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;"><?php echo ($dataItem['category_name']) ?></div>
                                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 50px; left: 10px;">Views: <?php echo ($dataItem['views']) ?></div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4><?php echo ($dataItem['name']) ?></h4>
                                                <p>Quantity: <?php echo ($dataItem['quantity']) ?></p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-0"><?php echo ($dataItem['price']) ?> VNĐ</p>
                                                </div>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-eye" aria-hidden="true"></i> View</a>
                                                    <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tab-4" class="tab-pane fade show p-0">
                    <div class="row g-4">
                        <div class="col-lg-12">
                            <div class="row g-4">
                                <?php foreach ($lessCommon as $dataItem) { ?>
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <img src="<?php echo ($dataItem['img']) ?>" class="img-fluid w-100 rounded-top" alt="">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;"><?php echo ($dataItem['category_name']) ?></div>
                                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 50px; left: 10px;">Views: <?php echo ($dataItem['views']) ?></div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4><?php echo ($dataItem['name']) ?></h4>
                                                <p>Quantity: <?php echo ($dataItem['quantity']) ?></p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-0"><?php echo ($dataItem['price']) ?> VNĐ</p>
                                                </div>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-eye" aria-hidden="true"></i> View</a>
                                                    <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid vesitable py-5">
    <div class="container py-5">
        <?php foreach ($categories as $key => $value) { ?>
            <h1 class="mb-0"><?php echo $key ?></h1>
            <div class="owl-carousel vegetable-carousel justify-content-center">
                <?php foreach ($value as $item) { ?>
                    <div class="border border-primary rounded position-relative vesitable-item">
                        <div class="vesitable-img">
                            <img src="<?php echo $item['img'] ?>" class="img-fluid w-100 rounded-top" alt="">
                        </div>
                        <div class="p-4 rounded-bottom">
                            <h4><?php echo $item['name'] ?></h4>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                            <div class="d-flex justify-content-between flex-lg-wrap">
                                <p class="text-dark fs-5 fw-bold mb-0">$4.99 / kg</p>
                                <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>