<script>
    /** Show sweet alert confirem message **/
    $(document).on('click', '.delete-item', function (e) {
        e.preventDefault()

        let url = $(this).data('url');
        // let url = $(this).attr('href');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    method: 'DELETE',
                    url: url,
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            toastr.success(response.message)

                            window.location.reload();

                        } else if (response.status === 'error') {
                            toastr.error(response.message)
                        }
                    },
                    error: function (error) {
                        console.error(error);
                    }
                })
            }
        })
    })

    function addToWishlist(productId) {
        $.ajax({
            method: 'GET',
            url: '{{ route("wishlist.store", ":productId") }}'
                .replace(':productId', productId),
            beforeSend: function () {
                // showLoader()
            },
            success: function (response) {
                toastr.success(response.message);
            },
            error: function (xhr, status, error) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function (index, value) {
                    toastr.error(value);
                })
                // hideLoader()
            },
            complete: function () {
                // hideLoader()
            }
        })
    }

</script>
