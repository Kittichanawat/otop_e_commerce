<script>
    window.onload = function() {
        updateCartItemCount();
    };

    function addToCart(prd_id, mmb_id, pty_id, prd_name, item_totals) {
        var crt_amount = 1; // ค่า crt_amount ที่คุณต้องการเพิ่ม
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "update_cart.php?prd_id=" + prd_id + "&mmb_id=" + mmb_id + "&pty_id=" + pty_id + "&crt_amount=" + crt_amount + "&prd_name=" + prd_name + "&item_totals=" + item_totals, true);
        xhr.onload = function() {
            if (xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'เพิ่มสินค้าลงในตะกร้าแล้ว',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    updateCartItemCount();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด!',
                        text: response.message,
                        confirmButtonText: 'ตกลง'
                    });
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด!',
                    text: 'ไม่สามารถเพิ่มสินค้าลงในตะกร้าได้',
                    confirmButtonText: 'ตกลง'
                });
            }
        };
        xhr.send();
    }



    function updateCartItemCount() {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "get_cart_item_count.php", true);
        xhr.onload = function() {
            if (xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    var cartItemCount = response.cartItemCount;
                    document.getElementById('cartItemCount').innerHTML = cartItemCount;
                }
            } else {
                console.error('เกิดข้อผิดพลาดในการดึงข้อมูลจำนวนสินค้าในตะกร้า');
            }
        };
        xhr.send();
    }
</script>











<script>
    function logout() {
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'ออกจากระบบสำเร็จ',
            showConfirmButton: false,
            timer: 1500
        }).then((result) => {
            if (result) {
                window.location.href = 'logout.php';
            }
        })
    }
</script>


<script>
    function logout_line() {
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'ออกจากระบบสำเร็จ',
            showConfirmButton: false,
            timer: 1500
        }).then((result) => {
            if (result) {
                window.location.href = 'php-line-login-main/logout.php';
            }
        })
    }
</script>

<!-- add cart function -->
<script>
    $(document).ready(function() {
        $('[data-toggle="modal"]').on('click', function() {
            var target = $(this).data('target');
            $(target).modal('show');
        });
    });
</script>


<!-- Bootstrap5 script -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Validate -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

<!-- Owl Carousel JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<!-- Custom JS -->
<script src="assets/js/custom.js"></script>


<!-- Custom Script for Owl Carousel Initialization -->
<script>
    $(document).ready(function() {
        $(".owl-carousel").owlCarousel({
            loop: true, // ให้วนลูปเลื่อนอย่างต่อเนื่อง
            margin: 20,
            responsiveClass: true,
            autoplay: true, // เปิดใช้งาน autoplay
            autoplayTimeout: 3000, // เวลาหน่วงระหว่างการเปลี่ยน slide (2 วินาที)
            autoplaySpeed: 3000, // ความเร็วในการเปลี่ยน slide (1 วินาที)
            slideTransition: 'linear', // การเปลี่ยน slide เป็นแบบ linear
            autoplayHoverPause: true, // หยุดเมื่อมีการ hover
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 2,
                    nav: false
                },
                1000: {
                    items: 3,
                    nav: true
                }
            }
        });
    });
</script>
<script src="script.js"></script>