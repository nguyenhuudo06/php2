function actionDelete(event) {
    event.preventDefault();
    let urlRequest = $(this).data('url');
    let that = $(this);
    // that.parent().parent().remove();

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
                type: 'GET',
                url: urlRequest,
                success: function (data) {
                    that.parent().parent().remove();
                    Swal.fire("Deleted!", "Your file has been deleted.", "success");
                    console.log(data);
                    // Xử lý dữ liệu ở đây
                },
                error: function(error) {
                    console.error('Error:', error);
                }
                
            });

        }
    });
}

$(function () {
    $(document).on('click', '.action-delete', actionDelete);
});