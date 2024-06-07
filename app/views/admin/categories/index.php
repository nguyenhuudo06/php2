<div class="content-wrapper mt-2">

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Parent category</th>
                                <th>Home show</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <?php foreach ($all as $dataItem) { ?>
                                    <tr>
                                        <td><?php echo ($dataItem['id']) ?></td>
                                        <td><?php echo ($dataItem['name']) ?></td>
                                        <td><?php echo ($dataItem['parent_name']) ?></td>
                                        <td><?php echo ($dataItem['home']) ?></td>
                                        <td>
                                            <button type="button" class="btn btn-outline-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                            <button type="button" class="btn btn-outline-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>