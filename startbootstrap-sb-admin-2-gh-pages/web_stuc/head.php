<head>
    <?php session_start(); ?>
    <?php
if ((isset($_SESSION['admin']) && $_SESSION['admin'] == 1) || (isset($_SESSION['superadmin']) && $_SESSION['superadmin'] == 1)) {
    // ผู้ใช้เป็น admin หรือ superadmin
    // ทำงานที่นี่
} else {
    // ผู้ใช้ไม่ใช่ admin และไม่ใช่ superadmin
    // ทำการเปลี่ยนเส้นทางหรือดำเนินการที่คุณต้องการที่นี่ เช่น การเปลี่ยนเส้นทางหรือแสดงข้อความแจ้งเตือน
    header('Location: ../../../'); // เปลี่ยนเส้นทางไปยังหน้าที่คุณต้องการ
    exit(); // ออกจากสคริปต์ปัจจุบัน
}

    // session_start();
    // if ($_SESSION["member"] == 1 && $_SESSION["status"] == "") {
    //     // ถ้ามีค่า member เป็น 1 และ status เป็นค่าว่าง ให้ทำการเปลี่ยนทางหรือกระทำตามที่คุณต้องการ
    //     header("Location: /project-jarnsax ");
    //     exit();
    // }
    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Buttons</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">

    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>


    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../../../Bos/plugins/bootstrap-toggle/bootstrap-toggle.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.css">
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css" rel="stylesheet">
   

    <style>
        body {

            font-family: 'Kanit', sans-serif;
        }
        #popupContainer {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
        .toggle.ios,
        .toggle-on.ios,
        .toggle-off.ios {
            border-radius: 20rem;
        }

        .toggle.ios .toggle-handle {
            border-radius: 20rem;
        }

        .image-container {
            position: relative;
            display: inline-block;
        }

        /* The image */
        .image-container img {
            max-width: 300px;
            max-height: 300px;
        }

        /* The delete link */
        .delete-link {
            position: absolute;
            top: 0;
            right: 0;
            background-color: red;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            cursor: pointer;
        }

        .delete-button {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .preview-image {
            max-width: 100px;
            max-height: 100px;
            margin-right: 10px;
        }

        .image-container {
            display: inline-block;
            margin: 5px;
            border: 1px solid #ddd;
            padding: 5px;
        }

        th:nth-child(3),
        td:nth-child(3) {
            max-width: 150px;
            /* ปรับขนาดของคอลัมน์รายละเอียด */
            white-space: nowrap;
            /* อักขระที่ยาวเกินจะไม่ขึ้นบรรทัดใหม่ */
            overflow: hidden;
            /* ซ่อนข้อความที่เกินขอบเขตของคอลัมน์ */
            text-overflow: ellipsis;
            /* แสดงเครื่องหมาย ... ถ้าข้อความยาวเกิน */
        }


        .map-container {
            max-width: 200px;
            /* ปรับขนาดตามที่คุณต้องการ */
            max-height: 200px;
            /* ปรับขนาดตามที่คุณต้องการ */
            overflow: hidden;
            /* ถ้ารูปใหญ่กว่า max-width/max-height */
        }

        .map-container img {
            width: 100%;
            height: auto;
        }
    </style>

</head>