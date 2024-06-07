$(document).ready(function () {
    $("#example1").DataTable({
        order: [[0, 'desc']],
        columnDefs: [
            { orderable: false, targets: [10] }
        ]
    });
});