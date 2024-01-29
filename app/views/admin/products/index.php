<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Products</h6>
                    </div>
                </div>
                <div class="card-body px-3 py-2">
                <button class="btn badge badge-sm bg-gradient-success">Add +</button>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Price</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Created by</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ps-2 opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ps-2 opacity-7">Categorie</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ps-2 opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($lists)) {
                                    foreach ($lists as $value) { ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="image-container me-3">
                                                        <img src="<?php echo $value['feature_image_path'] ?>" class="avatar border-radius-lg" alt="user1">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm truncate"><?php echo $value['name'] ?></h6>
                                                        <p class="text-xs text-secondary mb-0">Id: <?php echo $value['id'] ?></p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0"><?php echo number_format($value['price'], 2, ',', '.')  ?></p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0"><?php echo $value['user_id'] ?></p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-success">Online</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold"><?php echo $value['category_name'] ?></span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-primary font-weight-bold text-xs p-2 editBtn">
                                                    Edit
                                                </span>
                                                <span class="text-primary font-weight-bold text-xs p-2 editBtn action-delete" data-url="<?php echo _WEB_ROOT_ ?>\admin\product\delete\<?php echo $value['id'] ?>">
                                                    Delete
                                                </span>
                                            </td>
                                        </tr>
                                <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer py-4  ">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-lg-between">
                <div class="col-lg-6 mb-lg-0 mb-4">
                    <div class="copyright text-center text-sm text-muted text-lg-start">
                        © <script>
                            document.write(new Date().getFullYear())
                        </script>,
                        made with <i class="fa fa-heart"></i> by
                        <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
                        for a better web.
                    </div>
                </div>
                <div class="col-lg-6">
                    <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                        <li class="nav-item">
                            <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative Tim</a>
                        </li>
                        <li class="nav-item">
                            <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a href="https://www.creative-tim.com/blog" class="nav-link text-muted" target="_blank">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted" target="_blank">License</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</div>