
    $(document).ready(function() {
        $('#productSearch').keyup(function() {
            let query = $(this).val();
            if (query !== '') {
                $.ajax({
                    url: 'search.php',
                    method: 'POST',
                    data: {query: query},
                    success: function(data) {
                        $('#searchResults').html(data).show();
                    }
                });
            } else {
                $('#searchResults').hide();
            }
        });

        $(document).on('click', '.product-item', function() {
            // Redirect to product_detail.php with encoded product ID
            let productId = $(this).data('id');
            window.location.href = 'product_detail.php?prd_id=' + btoa(productId);
        });

        // Hide searchResults when clicking outside the search box and card
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#productSearch, #searchResults').length) {
                $('#searchResults').hide();
            }
        });
    });
