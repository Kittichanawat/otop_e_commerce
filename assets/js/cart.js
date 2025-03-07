/**
 **** AppzStory QR Payment API ****
 * 
 * @link https://appzstory.dev
 * @author Yothin Sapsamran (Jame AppzStory Studio) 
 */
$(function(){
    /** ส่วนประกอบหน้าเว็บไซต์ */
    $("#navbar").load("includes/navbar.html")
    $("#footer").load("includes/footer.html")

    /** ดึงข้อมูลสินค้าจาก Session Storage */
    let getCart = JSON.parse(sessionStorage.getItem('cart'))
    if(getCart){
        /** แสดงข้อมูลสินค้าที่เลือกออกทางหน้าจอ */
        getCart.forEach(item => {
            $("#renderCart").append(
                `<div class="row p-2">
                    <div class="col-lg-5 mb-3">
                        <div class="bg-light d-flex align-items-center justify-content-center">
                            <img src="uploads/${item.p_img}" class="img-cover shadow-sm" id="p_img" alt="AppzStory">
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="card-body text-center text-lg-start p-3">
                            <h4 class="card-title fw-bold">${item.p_name}</h4>
                            <div class="card-text">
                                <div class="mb-5">
                                    <p>${item.p_title}</p>
                                </div>
                            </div>
                            <div class="card-price ">
                                <h5 class="fw-bold ">ราคาทั้งหมด <span class="text-danger">${item.price}</span> บาท</h5>
                            </div>
                        </div>
                    </div>
                </div>`
            )
        })

        $('#totalPrice').text(getCart[0].price)
        $('#lastTotalPrice').text(getCart[0].price)

        /**
         * Form Validate ตรวจสอบการกรอกข้อมูล
         * Submit Form บันทึกรายการสั่งซื้อ
         */
        $("#formOrder").validate({
            /** Submit Form */
            submitHandler: function(form, e) {
                e.preventDefault()
                $('#submit button').remove()
                $('#submit').append(`<button class="btn btn-info text-white" type="button" disabled>
                                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                    </button>`)
                let formData = new FormData()
                let serialize = $(form).serializeArray()
                serialize.forEach( function (item) {
                    formData.append(item.name, item.value)
                })
                formData.append('cartItem', JSON.stringify(getCart))
                $.ajax({
                    type: 'POST',
                    url: 'service/api/qrcode/create',
                    data: formData,
                    processData: false, // กำหนดเป็น false เพื่อให้สามารถส่งแบบไม่ต้องประมวลผลใดๆ
                    contentType: false // กำหนดเป็น false เพื่อไม่ให้ตั้งค่า content header ใดๆ
                }).done(function(data){ 
                    location.assign('./payment.html?ref=' + data.response.referenceNo)
                }).fail(function(){ 
                    alert('ไม่สามารถดำเนินการชำระเงินได้')
                })
            },
            /** กฎของการตรวจสอบข้อมูล */
            rules: {
                mmb_name: "required",
                mmb_email: {
                    required: true,
                    email: true
                },
                customer_phone: {
                    required: true,
                    number: true,
                    maxlength: 20
                }
            },
            /** ข้อความแสดงการตรวจสอบข้อมูล */
            messages:{
                mmb_name: 'โปรดกรอกข้อมูล ชื่อ - นามสกุล',
                mmb_email: {
                    required: 'โปรดกรอกข้อมูล Email',
                    email: 'โปรดกรอก Email ให้ถูกต้อง'
                },
                customer_phone: {
                    required: 'โปรดกรอกข้อมูล เบอร์โทรศัพท์',
                    number: 'โปรดกรอกตัวเลขเท่านั้น',
                    maxlength: 'โปรดกรอกตัวเลขไม่เกิน 20 ตัว',
                }
            },
            /** แสดงกรอบ highlight ของแต่ละเหตการณ์ */
            errorElement: 'div',
            errorPlacement: function ( error, element ){
                error.addClass( 'invalid-feedback' )
                error.insertAfter( element )
            },
            highlight: function ( element, errorClass, validClass ){
                $( element ).addClass( 'is-invalid' ).removeClass( 'is-valid' )
            },
            unhighlight: function ( element, errorClass, validClass ){
                $( element ).addClass( 'is-valid' ).removeClass( 'is-invalid' )
            }
        })

    } else {
        location.assign('./')
    }

})