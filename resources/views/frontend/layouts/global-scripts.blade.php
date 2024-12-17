<script>
    function addToWishlist(productId){
    $.ajax({
        method: 'GET',
        url: '{{ route("wishlist.store", ":productId") }}'.replace(':productId', productId),
        beforeSend: function(){
            // showLoader()
        },
        success: function(response){
            toastr.success(response.message);
        },
        error: function(xhr, status, error){
            let errors = xhr.responseJSON.errors;
            $.each(errors, function(index, value) {
                toastr.error(value);
            })
            // hideLoader()
        },
        complete: function(){
            // hideLoader()
        }
    })
}
</script>
