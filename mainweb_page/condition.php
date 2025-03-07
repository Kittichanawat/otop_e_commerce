<?php
 if (isset($_SESSION['member']) && $_SESSION['member'] == 1 && empty($_SESSION['status'])) {
    // ถ้ามี session 'member' และ 'member' เท่ากับ 1 และ 'status' เป็นค่าว่าง
    // ให้ทำงานที่นี่
    header("Location: /project-jarnsax"); // Redirect ไปยังหน้า index.php หรือหน้าอื่นที่คุณต้องการ
    exit(); // จบการทำงานของสคริปต์
} 
// session_start();
// if ($_SESSION["member"] == 1 && $_SESSION["status"] == "") {
//     // ถ้ามีค่า member เป็น 1 และ status เป็นค่าว่าง ให้ทำการเปลี่ยนทางหรือกระทำตามที่คุณต้องการ
//     header("Location: /project-jarnsax ");
//     exit();
// }
?>