<?php

/**
 * Page Manager
 * 
 * @link https://appzstory.dev
 * @author Yothin Sapsamran (Jame AppzStory Studio)
 */
require_once('../authen.php');
require_once('../condition.php');
// if ($_SESSION["status "] == "member" ) {
//     header("Location: ../dashboard/");
//     exit(); // Stop script execution
// }
// ตรวจสอบสถานะของผู้ใช้
if ($_SESSION["status"] == "admin") {
    // ถ้าผู้ใช้มีสถานะ "admin" ให้เปลี่ยนเส้นทางไปยังหน้าอื่น (เช่นหน้าหลัก)
    header("Location: ../dashboard/");
    exit(); // หยุดการดำเนินการของสคริปต์
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>จัดการผู้ดูแลระบบ | AppzStory</title>
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon.ico">
    <!-- stylesheet -->
    <link rel="stylesheet" href="../../plugins/bootstrap-toggle/bootstrap-toggle.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
    <!-- Datatables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include_once('../includes/sidebar.php') ?>
        <div class="content-wrapper pt-3">
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-header border-0 pt-4">
                                    <h4>
                                        <i class="fas fa-user-cog"></i>
                                        ผู้ดูแลระบบ
                                    </h4>
                                    <a href="form-create.php" class="btn btn-primary mt-3">
                                        <i class="fas fa-plus"></i>
                                        เพิ่มข้อมูล
                                    </a>
                                </div>
                                <div class="card-body">
                                    <table id="logs" class="table table-hover" width="100%">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>ชื่อผู้ใช้งาน</th>
                                                <th>ชื่อจริง</th>
                                                <th>นามสกุล</th>
                                                <th>อีเมล</th>
                                                <th>ใช้งานล่าสุด</th>
                                                <th>สิทธิ์เข้าใช้งาน</th>
                                                <th>สถานะบัญชี</th>
                                                <th>จัดการ</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once('../includes/footer.php') ?>
    </div>

    <!-- scripts -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="../../assets/js/adminlte.min.js"></script>
    <script src="../../plugins/toastr/toastr.min.js"></script>

    <!-- datatables -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

    <script src="../../plugins/bootstrap-toggle/bootstrap-toggle.min.js"></script>
  
    <script>
        $(function() {
            // สร้างตาราง DataTables และโหลดข้อมูล
            $.ajax({
                type: "GET",
                url: "../../service/manager/index.php"
            }).done(function(data) {
                let tableData = [];
                data.response.forEach(function(item, index) {
                    let adminLabel = item.status === "admin" ?
                        '<span class="badge badge-info">admin</span>' : (item.status ===
                            "superadmin" ? '<span class="badge badge-danger">superadmin</span>' : ''
                        );
                        let deleteButton = (item.mmb_username !== '<?php echo $_SESSION['mmb_username']; ?>' && item.status !== 'superadmin') ?
    `<button type="button" class="btn btn-danger delete-manager" data-id="${item.mmb_id}">
    <i class="far fa-trash-alt"></i> ลบ
</button>
` : ''; 
                        

                    // เพิ่มส่วนของ toggle
                    let toggleMmbShow = '';
                    let toggleTempBan = '';
                    let editButton = (item.mmb_username !== '<?php echo $_SESSION['mmb_username']; ?>' && item.status !== 'superadmin') ?
    `<a href="form-edit.php?mmb_id=${item.mmb_id}" type="button" class="btn btn-warning text-white">
        <i class="far fa-edit"></i> แก้ไข
    </a>
` : '';
if (item.mmb_username !== '<?php echo $_SESSION['mmb_username']; ?>') {
    if (item.status !== 'superadmin') {
        toggleMmbShow =
            `<input class="toggle-mmb-show" data-id="${item.mmb_id}" type="checkbox" data-toggle="toggle" data-on="เผยแพร่" data-off="ปิด" data-onstyle="success" data-style="ios" ${item.mmb_show == 1 ? 'checked' : ''}> `;
        toggleTempBan =
            `<input class="toggle-mmb-show" data-id="${item.mmb_id}" type="checkbox" data-toggle="toggle" data-on="เผยแพร่" data-off="ปิด" data-onstyle="success" data-style="ios" ${item.mmb_show == 0 ? 'checked' : ''}>`;
    } else {
        toggleMmbShow = '<div class="bg-danger text-white p-1 rounded">ไม่สามารถแก้ไขผู้ใช้ระดับเดียวกัน</div>';
        toggleTempBan = '<div class="bg-danger text-white p-1 rounded">ไม่สามารถแก้ไขผู้ใช้ระดับเดียวกัน</div>';
    }
}

                    tableData.push([
                        item.mmb_id,
                        item.mmb_username,
                        item.mmb_name,
                        item.mmb_surname,
                        item.mmb_phone,
                        item.mmb_email,
                        adminLabel,
                        toggleMmbShow, // เผยแพร่ผู้ใช้งาน / ปิดบัญชีชั่วคราว
                        `<div class="btn-group" role="group">
                        ${ editButton }
                        ${deleteButton}
                    </div>`
                    ])
                })
                initDataTables(tableData);
                // เปิดใช้งาน toggle
                $('.toggle-mmb-show').bootstrapToggle();
            }).fail(function() {
                // โค้ดแจ้งเตือนเมื่อไม่สามารถโหลดข้อมูลได้
                Swal.fire({
                    text: 'ไม่สามารถเรียกดูข้อมูลได้',
                    icon: 'error',
                    confirmButtonText: 'ตกลง',
                }).then(function() {
                    location.assign('../dashboard')
                })
            });

            // เพิ่มโค้ดสำหรับจัดการ toggle
            $(document).on('change', '.toggle-mmb-show', function() {
                let id = $(this).data('id');
                let isChecked = $(this).prop('checked');
                updateMmbShow(id, isChecked);
            });

            function updateMmbShow(id, isChecked) {
                $.ajax({

                    type: "PUT",
                    url: "../../service/manager/update_mmb_show.php",
                    data: JSON.stringify({
                        id: id,
                        mmb_show: isChecked ? 1 : 0
                    }),
                    contentType: "application/json; charset=utf-8",

                    success: function(response) {
                        // อัปเดตสำเร็จ
                        toastr.success('อัพเดทข้อมูลเสร็จเรียบร้อย');
                    },
                    error: function() {
                        // อัปเดตไม่สำเร็จ
                        toastr.error('เกิดข้อผิดพลาดในการอัปเดท');
                    }
                });
            }



            // สร้าง DataTables
            function initDataTables(tableData) {
                $('#logs').DataTable({
                    data: tableData,
                    columns: [{
                            title: "ลำดับ",
                            className: "align-middle"
                        },
                        {
                            title: "ชื่อผู้ใช้งาน",
                            className: "align-middle"
                        },
                        {
                            title: "ชื่อจริง",
                            className: "align-middle"
                        },
                        {
                            title: "นามสกุล",
                            className: "align-middle"
                        },
                        {
                            title: "เบอร์โทร",
                            className: "align-middle"
                        },
                        {
                            title: "อีเมล",
                            className: "align-middle"
                        },
                        {
                            title: "สิทธิ์เข้าใช้งาน",
                            className: "align-middle"
                        },
                        {
                            title: "สถานะบัญชี",
                            className: "align-middle"
                        }, // รวมคอลัมน์ "เผยแพร่ผู้ใช้งาน" และ "ปิดบัญชีชั่วคราว"
                        {
                            title: "จัดการ",
                            className: "align-middle"
                        }
                    ],
                    // initComplete: function() {
                    //     $(document).on('click', '.delete-manager', function() {
                    //         let id = $(this).data('id');
                    //         let index = $(this).data('index');
                    //         Swal.fire({
                    //             text: "คุณแน่ใจหรือไม่...ที่จะลบรายการนี้?",
                    //             icon: 'warning',
                    //             showCancelButton: true,
                    //             confirmButtonText: 'ใช่! ลบเลย',
                    //             cancelButtonText: 'ยกเลิก'
                    //         }).then((result) => {
                    //             if (result.isConfirmed) {
                    //                 $.ajax({
                    //                     type: "DELETE",
                    //                     url: "../../service/manager/delete.php",
                    //                     data: {
                    //                         id: id
                    //                     }
                    //                 }).done(function() {
                    //                     Swal.fire({
                    //                         text: 'รายการของคุณถูกลบเรียบร้อย',
                    //                         icon: 'success',
                    //                         confirmButtonText: 'ตกลง',
                    //                     }).then((result) => {
                    //                         location.reload()
                    //                     })
                    //                 })
                    //             }
                    //         })
                    //     })
                    // },

                    responsive: {
                        details: {
                            display: $.fn.dataTable.Responsive.display.modal({
                                header: function(row) {
                                    var data = row.data()
                                    return 'ผู้ใช้งาน: ' + data[1]
                                }
                            }),
                            renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                                tableClass: 'table'
                            })
                        }
                    },
                    language: {
                        "lengthMenu": "แสดงข้อมูล _MENU_ แถว",
                        "zeroRecords": "ไม่พบข้อมูลที่ต้องการ",
                        "info": "แสดงหน้า _PAGE_ จาก _PAGES_",
                        "infoEmpty": "ไม่พบข้อมูลที่ต้องการ",
                        "infoFiltered": "(filtered from _MAX_ total records)",
                        "search": 'ค้นหา',
                        "paginate": {
                            "previous": "ก่อนหน้านี้",
                            "next": "หน้าต่อไป"
                        }
                    }
                });
            }
        });
    </script>
    <script>
        $(document).on('click', '.delete-manager', function() {
            let id = $(this).data('id');
            Swal.fire({
                text: "คุณแน่ใจหรือไม่...ที่จะลบรายการนี้?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ใช่! ลบเลย',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "../../service/manager/delete.php?id=" +
                            id, // ส่งค่า id ผ่าน query parameter
                    }).done(function() {
                        Swal.fire({
                            text: 'รายการของคุณถูกลบเรียบร้อย',
                            icon: 'success',
                            confirmButtonText: 'ตกลง',
                        }).then((result) => {
                            location.reload()
                        })
                    })
                }
            })
        })
    </script>
    
</body>

</html>