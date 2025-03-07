function togglePromotionField() {
    var promotionSelect = document.getElementById('prd_promotion');
    var promotionPriceInput = document.getElementById('prd_promotion_price');

    // Enable or disable the promotion price field based on the selected option
    if (promotionSelect.value === '1') {
        promotionPriceInput.readOnly = false;
    } else {
        promotionPriceInput.readOnly = true;
        promotionPriceInput.value = ''; // Clear the value
    }
}


// Function to preview selected image
function previewImage(input) {
    var imagePreview = document.getElementById('imagePreview');
    if (input.files && input.files[ 0 ]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            imagePreview.style.display = 'block';
            imagePreview.style.maxWidth = '100px';
            imagePreview.style.maxHeight = '100px';
            imagePreview.src = e.target.result;
        };
        reader.readAsDataURL(input.files[ 0 ]);
    } else {
        imagePreview.style.display = 'none';
        imagePreview.src = '#';
    }
}



document.addEventListener('DOMContentLoaded', function() {
    const mainImageInput = document.getElementById('new_image'); // เปลี่ยนชื่อตัวแปร
    const additionalImagesInput = document.getElementById('new_image');
    const previewImagesDiv = document.getElementById('preview-image');

    additionalImagesInput.addEventListener('change', function() {
        previewImagesDiv.innerHTML = '';

        if (this.files && this.files.length > 0) {
            for (let i = 0; i < this.files.length; i++) {
                const file = this.files[i];
                if (file.type.startsWith('image/')) {
                    const imgContainer = document.createElement('div');
                    imgContainer.classList.add('image-container');

                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.classList.add('preview-image');
                    img.style.maxWidth = '100px';
                    img.style.maxHeight = '100px';

                    const deleteButton = document.createElement('button');
                    deleteButton.textContent = 'Delete';
                    deleteButton.classList.add('delete-button');

                    deleteButton.addEventListener('click', function() {
                        // ลบรูปภาพ
                        imgContainer.remove();

                        // สร้างรายการไฟล์ใหม่ที่ไม่รวมไฟล์ที่ถูกลบ
                        const updatedFiles = Array.from(additionalImagesInput
                                .files)
                            .filter(inputFile => inputFile !== file);

                        // สร้าง FileList ใหม่
                        const newFileList = new DataTransfer();
                        updatedFiles.forEach(updatedFile => {
                            newFileList.items.add(updatedFile);
                        });

                        // กำหนด FileList ใหม่ใน input
                        additionalImagesInput.files = newFileList.files;
                    });

                    imgContainer.appendChild(img);
                    imgContainer.appendChild(deleteButton);

                    previewImagesDiv.appendChild(imgContainer);
                }
            }
        }
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const mainImageInput = document.getElementById('new_image'); // เปลี่ยนชื่อตัวแปร
    const additionalImagesInput = document.getElementById('new_image');
    const previewImagesDiv = document.getElementById('preview-image');

    additionalImagesInput.addEventListener('change', function() {
        previewImagesDiv.innerHTML = '';

        if (this.files && this.files.length > 0) {
            for (let i = 0; i < this.files.length; i++) {
                const file = this.files[i];
                if (file.type.startsWith('image/')) {
                    const imgContainer = document.createElement('div');
                    imgContainer.classList.add('image-container');

                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.classList.add('preview-image');
                    img.style.maxWidth = '100px';
                    img.style.maxHeight = '100px';

                    const deleteButton = document.createElement('button');
                    deleteButton.textContent = 'Delete';
                    deleteButton.classList.add('delete-button');

                    deleteButton.addEventListener('click', function() {
                        // ลบรูปภาพ
                        imgContainer.remove();

                        // สร้างรายการไฟล์ใหม่ที่ไม่รวมไฟล์ที่ถูกลบ
                        const updatedFiles = Array.from(additionalImagesInput
                                .files)
                            .filter(inputFile => inputFile !== file);

                        // สร้าง FileList ใหม่
                        const newFileList = new DataTransfer();
                        updatedFiles.forEach(updatedFile => {
                            newFileList.items.add(updatedFile);
                        });

                        // กำหนด FileList ใหม่ใน input
                        additionalImagesInput.files = newFileList.files;
                    });

                    imgContainer.appendChild(img);
                    imgContainer.appendChild(deleteButton);

                    previewImagesDiv.appendChild(imgContainer);
                }
            }
        }
    });
});

function checkFileType(fileInput) {
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i; // ระบุสกุลไฟล์ที่ยอมรับ

    if (!allowedExtensions.exec(filePath)) {
        alert('ขออภัย, สามารถอัพโหลดได้เฉพาะไฟล์รูปภาพเท่านั้น: .jpg, .jpeg, .png, .gif');
        fileInput.value = '';
        return false;
    }
    return true;
}


function check2FileType(fileInput) {
var files = fileInput.files;

for (var i = 0; i < files.length; i++) {
var file = files[i];
var fileName = file.name;
var fileExtension = fileName.split('.').pop().toLowerCase();
var allowedExtensions = ["jpg", "jpeg", "png", "gif"];

if (allowedExtensions.indexOf(fileExtension) === -1) {
alert('ขออภัย, ไฟล์ ' + fileName + ' ไม่ใช่รูปภาพที่ยอมรับ: .jpg, .jpeg, .png, .gif');
fileInput.value = ''; // เคลียร์ค่า input ที่มีไฟล์ที่ไม่ถูกต้อง
return false;
}
}

return true;
}


function confirmDelete(prd_id,prd_name) {
    Swal.fire({
        title: 'ยืนยันการลบข้อมูล',
        text: `คุณต้องการลบรูป "${prd_name}" ใช่หรือไม่?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            // ถ้าผู้ใช้กดยืนยันการลบ
            fetch(`delete_current_img.php?prd_id=${prd_id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('ลบสำเร็จ', 'ข้อมูลได้ถูกลบเรียบร้อย', 'success').then(() => {
                            // รีโหลดหน้าหลังจากลบสำเร็จ
                            window.location.reload();
                        });
                    } else {
                        Swal.fire('ลบไม่สำเร็จ', 'เกิดข้อผิดพลาดในการลบข้อมูล', 'error');
                    }
                })
                .catch(error => {
                    console.error('เกิดข้อผิดพลาดในการส่งคำร้องขอ: ', error);
                    Swal.fire('ข้อผิดพลาด', 'ไม่สามารถลบข้อมูลได้', 'error');
                });
        }
    });
}


function confirmDeleteImageAddition(prd_id,img_id) {
    Swal.fire({
        title: 'ยืนยันการลบข้อมูล',
        text: `คุณต้องการลบรูป"${img_id}" ใช่หรือไม่?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            // ถ้าผู้ใช้กดยืนยันการลบ
            fetch(`delete_image.php?img_id=${img_id}&prd_id=${prd_id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('ลบสำเร็จ', 'ข้อมูลได้ถูกลบเรียบร้อย', 'success').then(() => {
                            // รีโหลดหน้าหลังจากลบสำเร็จ
                            window.location.reload();
                        });
                    } else {
                        Swal.fire('ลบไม่สำเร็จ', 'เกิดข้อผิดพลาดในการลบข้อมูล', 'error');
                    }
                })
                .catch(error => {
                    console.error('เกิดข้อผิดพลาดในการส่งคำร้องขอ: ', error);
                    Swal.fire('ข้อผิดพลาด', 'ไม่สามารถลบข้อมูลได้', 'error');
                });
        }
    });
}
